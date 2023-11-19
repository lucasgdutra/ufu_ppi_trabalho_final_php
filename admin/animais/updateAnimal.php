<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
    http_response_code(401); // Unauthorized
    echo "Access denied. Please log in.";
    exit;
}

require_once "../../classes/Database.php";



function updateAnimal($id, $nome, $nome_cientifico, $classe, $numero_individuos, $risco_extincao, $photoPath, $descricao)
{
    global $conn;
    // Start building the SQL query
    $sql = "UPDATE animais SET ";
    $params = [];
    $updateFields = [];

    if (!empty($nome)) {
        $updateFields[] = "nome = :nome";
        $params[':nome'] = $nome;
    }

    if (!empty($nome_cientifico)) {
        $updateFields[] = "nome_cientifico = :nome_cientifico";
        $params[':nome_cientifico'] = $nome_cientifico;
    }

    if (!empty($nome_cientifico)) {
        $updateFields[] = "classe = :classe";
        $params[':classe'] = $classe;
    }

    if (!empty($numero_individuos)) {
        $updateFields[] = "numero_individuos = :numero_individuos";
        $params[':numero_individuos'] = $numero_individuos;
    }

    if (!empty($risco_extincao)) {
        $updateFields[] = "risco_extincao = :risco_extincao";
        $params[':risco_extincao'] = $risco_extincao;
    }


    if ($photoPath !== null) { // Assuming empty path is not valid; adjust as needed
        $updateFields[] = "imagem_url = :imagem";
        $params[':imagem'] = $photoPath;
    }

    if (!empty($descricao)) {
        $updateFields[] = "descricao = :descricao";
        $params[':descricao'] = $descricao;
    }


    if (count($updateFields) === 0) {
        // No fields to update
        return false;
    }

    $sql .= implode(', ', $updateFields);

    $sql .= " WHERE id = :id";
    $params[':id'] = $id;

    try {
        $stmt = $conn->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw $e;
    }
}

function uploadAnimalPhoto($file)
{
    $target_dir = "../../img/animais/"; // Ensure this path is correct relative to your script's location


    // Validate file is an image
    if ($file['error']) {
        echo "Error while uploading: " . $file['error'];
        return false;
    }

    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        return false;
    }



    $baseFileName = uniqid('animal_', true);
    $targetFileWebPSmall = $target_dir . $baseFileName . '-pequeno.webp';
    $targetFileWebPLarge = $target_dir . $baseFileName . '-grande.webp';
    // $targetFileJPG = $target_dir . $baseFileName . '.jpg';

    require_once "../../utils/convertImage.php";

    // Convert to WebP
    $resultWebP = convertImage($file['tmp_name'], $targetFileWebPSmall, 'webp', null, 250);
    if (!$resultWebP['success']) {
        echo "Error converting to WebP: " . $resultWebP['error'];
        return false;
    }

    $resultWebP = convertImage($file['tmp_name'], $targetFileWebPLarge, 'webp', 450, null);
    if (!$resultWebP['success']) {
        echo "Error converting to WebP: " . $resultWebP['error'];
        return false;
    }

    // Convert to JPG
    // $resultJPG = convertImage($file['tmp_name'], $targetFileJPG, 'jpg', null, 40);
    // if (!$resultJPG['success']) {
    //     echo "Error converting to JPG: " . $resultJPG['error'];
    //     return false;
    // }



    return str_replace(
        '/img/animais/',
        '',
        str_replace('//', '/', str_replace('../', '/', $target_dir . $baseFileName))
    );
}

function checkIfAnimalExists($id)
{
    global $conn;
    $sql = "SELECT * FROM animais WHERE id = :id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();

    // Retrieve email and admin status from session


    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $nome_cientifico = $_POST['nome-cientifico'] ?? '';
    $numero_individuos = $_POST['quantidade-individuos'] ?? '';
    $risco_extincao = $_POST['risco-extincao'] ?? '';
    $classe = $_POST['classe'] ?? '';
    $animalPhoto = $_FILES['animalPhoto'] ?? '';
    $descricao = $_POST['descricao'] ?? '';


    if (empty($id)) {
        http_response_code(400); // Bad Request
        echo "id is required.";
        exit;
    }



    try {
        if (!checkIfAnimalExists($id)) {
            http_response_code(404);
            echo "Animal do not exists with this id.";
            exit;
        }
        $photoPath = !empty($animalPhoto) ? uploadAnimalPhoto($animalPhoto) : null;



        if (updateAnimal($id, $nome, $nome_cientifico, $classe, $numero_individuos, $risco_extincao, $photoPath, $descricao)) {
            http_response_code(200); // OK
            echo "Animal updated successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while updating the animal.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
