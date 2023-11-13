<?php
require_once "classes/Database.php";

function uploadProfilePhoto($file) {
    // Implement file upload logic here
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

    $photoPath = $profilePhoto ? uploadProfilePhoto($profilePhoto) : null;
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $database = new Database('mysql');
        $conn = $database->getConnection();

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, email, imagem) VALUES (:nome, :senha, :email, :imagem)");
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
