<?php
require_once "../classes/Database.php";

function uploadProfilePhoto($file)
{
    $target_dir = "../img/profile_photos/"; // Ensure this path is correct relative to your script's location
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

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

    require_once "../utils/convertImage.php";

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



    return str_replace('../', '/', $target_dir . $baseFileName);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $senha = $_POST['password'] ?? '';
    $profilePhoto = $_FILES['profilePhoto'] ?? null;

    if (empty($email) || empty($nome) || empty($senha)) {
        http_response_code(400); // Bad Request
        echo "All fields are required.";
        exit;
    }

    try {
        $database = new Database('mysql');
        $conn = $database->getConnection();

        // Check if user already exists
        $checkUserStmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $checkUserStmt->bindParam(':email', $email);
        $checkUserStmt->execute();

        if ($checkUserStmt->rowCount() > 0) {
            http_response_code(409); // Conflict
            echo "User already exists with this email.";
            exit;
        }

        $photoPath = $profilePhoto ? uploadProfilePhoto($profilePhoto) : null;
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, email, caminho_imagem) VALUES (:nome, :senha, :email, :imagem)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':senha', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':imagem', $photoPath);

        if ($stmt->execute()) {
            http_response_code(201); // Created
            echo "User registered successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while registering the user.";
        }

        $database->closeConnection();
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
