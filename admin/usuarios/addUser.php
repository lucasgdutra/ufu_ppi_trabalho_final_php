<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../../classes/Database.php";



function addUser($email, $nome, $hashedPassword, $photoPath, $isAdmin = false)
{
    global $conn;
    // Assuming a table `users` with columns `email`, `nome`, `senha`, `profilePhoto`, `isAdmin`
    $sql = "INSERT INTO usuarios (nome, senha, email, caminho_imagem, isAdmin) VALUES (:nome, :senha, :email, :imagem, :isAdmin)";

    try {
        $isAdmin = $isAdmin ? 1 : 0;
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':imagem', $photoPath);
        $stmt->bindParam(':isAdmin', $isAdmin);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw $e;
    }
}

function uploadProfilePhoto($file)
{
    $target_dir = "../../img/profile_photos/"; // Ensure this path is correct relative to your script's location


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



    $baseFileName = uniqid('profile_', true);
    $targetFileWebP = $target_dir . $baseFileName . '.webp';
    $targetFileJPG = $target_dir . $baseFileName . '.jpg';

    require_once "../../utils/convertImage.php";

    // Convert to WebP
    $resultWebP = convertImage($file['tmp_name'], $targetFileWebP, 'webp', null, 40);
    if (!$resultWebP['success']) {
        echo "Error converting to WebP: " . $resultWebP['error'];
        return false;
    }

    // Convert to JPG
    $resultJPG = convertImage($file['tmp_name'], $targetFileJPG, 'jpg', null, 40);
    if (!$resultJPG['success']) {
        echo "Error converting to JPG: " . $resultJPG['error'];
        return false;
    }



    return str_replace('//', '/', str_replace('../', '/', $target_dir . $baseFileName));
}

function checkIfUserExists($email)
{
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE email = :email";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();

    $email = $_POST['email'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $profilePhoto = $_FILES['profilePhoto'] ?? null;
    if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true) {
        $isAdmin = $_POST['isAdmin'] ?? false;
    } else {
        $isAdmin = false;
    }

    if (empty($email) || empty($nome) || empty($senha)) {
        http_response_code(400); // Bad Request
        echo "All fields are required.";
        exit;
    }

    try {
        // Check if user already exists
        if (checkIfUserExists($email)) {
            http_response_code(409); // Conflict
            echo "User already exists with this email.";
            exit;
        }

        $photoPath = $profilePhoto ? uploadProfilePhoto($profilePhoto) : null;
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        if (addUser($email, $nome, $hashedPassword, $photoPath, $isAdmin)) {
            http_response_code(201); // Created
            echo "User registered successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while registering the user.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
