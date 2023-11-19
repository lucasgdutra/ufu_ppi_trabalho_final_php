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

function deleteAnimal($id)
{
    global $conn;
    $sql = "DELETE FROM animais WHERE id = :id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw $e;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();



    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        http_response_code(400); // Bad Request
        echo "id is required.";
        exit;
    }



    try {
        if (deleteAnimal($id)) {
            http_response_code(200); // OK
            echo "Animal deleted successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while deleting the animal.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
