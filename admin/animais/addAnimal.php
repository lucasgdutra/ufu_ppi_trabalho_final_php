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



function addAnimal($nome, $nome_cientifico, $classe, $numero_individuos, $risco_extincao, $photoPath, $descricao)
{

    global $conn;
    // Assuming a table `users` with columns `email`, `nome`, `senha`, `profilePhoto`, `isAdmin`
    $sql = "INSERT INTO animais (nome, nome_cientifico, classe, numero_individuos, risco_extincao, imagem_url, descricao) VALUES (:nome, :nome_cientifico, :classe, :numero_individuos, :risco_extincao, :imagem_url, :descricao)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':nome_cientifico', $nome_cientifico);
        $stmt->bindParam(':classe', $classe);
        $stmt->bindParam(':numero_individuos', $numero_individuos);
        $stmt->bindParam(':risco_extincao', $risco_extincao);
        $stmt->bindParam(':imagem_url', $photoPath);
        $stmt->bindParam(':descricao', $descricao);

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

function checkIfAnimalExists($nome)
{
    global $conn;
    $sql = "SELECT * FROM animais WHERE nome = :nome";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();


    $nome = $_POST['nome'] ?? '';
    $nome_cientifico = $_POST['nome-cientifico'] ?? '';
    $numero_individuos = $_POST['quantidade-individuos'] ?? '';
    $risco_extincao = $_POST['risco-extincao'] ?? '';
    $classe = $_POST['classe'] ?? '';
    $animalPhoto = $_FILES['animalPhoto'] ?? '';
    $descricao = $_POST['descricao'] ?? '';


    if (empty($nome) || empty($nome_cientifico) || empty($risco_extincao) || empty($classe) || empty($animalPhoto) || empty($descricao)) {
        http_response_code(400); // Bad Request
        echo "All fields are required.";
        exit;
    }

    try {
        // Check if user already exists
        if (checkIfAnimalExists($nome)) {
            http_response_code(409); // Conflict
            echo "Animal already exists with this email.";
            exit;
        }
        $photoPath = $animalPhoto ? uploadAnimalPhoto($animalPhoto) : null;

        if (addAnimal($nome, $nome_cientifico, $classe, $numero_individuos, $risco_extincao, $photoPath, $descricao)) {
            http_response_code(201); // Created
            echo "Animal registered successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while registering the animal.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
