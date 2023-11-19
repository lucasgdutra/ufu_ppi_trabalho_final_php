<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_email'])) {
    http_response_code(401); // Unauthorized
    echo "Access denied. Please log in.";
    exit;
}

require_once "../../classes/Database.php";

function canUpdateUser($loggedInEmail, $isAdmin, $emailToUpdate)
{
    return $isAdmin || $loggedInEmail === $emailToUpdate;
}

function updateUser($email, $nome, $hashedPassword, $photoPath, $isAdmin = false)
{
    global $conn;
    // Start building the SQL query
    $sql = "UPDATE usuarios SET ";
    $params = [];
    $updateFields = [];

    if (!empty($nome)) {
        $updateFields[] = "nome = :nome";
        $params[':nome'] = $nome;
    }

    if (!empty($hashedPassword)) {
        $updateFields[] = "senha = :senha";
        $params[':senha'] = $hashedPassword;
    }

    if ($photoPath !== null) { // Assuming empty path is not valid; adjust as needed
        $updateFields[] = "caminho_imagem = :imagem";
        $params[':imagem'] = $photoPath;
    }

    $updateFields[] = "isAdmin = :isAdmin";
    $params[':isAdmin'] = $isAdmin ? 1 : 0;

    if (count($updateFields) === 0) {
        // No fields to update
        return false;
    }

    $sql .= implode(', ', $updateFields);
    $sql .= " WHERE email = :email";
    $params[':email'] = $email;

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

    // Retrieve email and admin status from session
    $loggedInEmail = $_SESSION['user_email'];
    $isAdmin = isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;
    $emailToUpdate = $_POST['email'] ?? '';

    $nome = $_POST['nome'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $profilePhoto = $_FILES['profilePhoto'] ?? null;
    if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true) {
        $isAdminUpdate = $_POST['isAdmin'] ?? false;
    } else {
        $isAdminUpdate = false;
    }

    // Check if the user has permission to update the specified user
    if (!canUpdateUser($loggedInEmail, $isAdmin, $emailToUpdate)) {
        http_response_code(403); // Forbidden
        echo "Access denied. You do not have permission to update this user.";
        exit;
    }

    if (empty($emailToUpdate)) {
        http_response_code(400); // Bad Request
        echo "Email is required.";
        exit;
    }



    try {
        $photoPath = $profilePhoto ? uploadProfilePhoto($profilePhoto) : null;
        $hashedPassword = !empty($senha) ? password_hash($senha, PASSWORD_DEFAULT) : null;


        if (updateUser($emailToUpdate, $nome, $hashedPassword, $photoPath, $isAdminUpdate)) {
            http_response_code(200); // OK
            echo "User updated successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while updating the user.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
