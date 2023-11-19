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

function deleteUser($email)
{
    global $conn;
    $sql = "DELETE FROM usuarios WHERE email = :email";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw $e;
    }
}

function canDeleteUser($loggedInEmail, $isAdmin, $emailToDelete)
{
    return $isAdmin || $loggedInEmail === $emailToDelete;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();

    $loggedInEmail = $_SESSION['user_email'];
    $isAdmin = isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;

    $emailToDelete = $_POST['email'] ?? '';

    if (empty($emailToDelete)) {
        http_response_code(400); // Bad Request
        echo "Email is required.";
        exit;
    }

    if (!canDeleteUser($loggedInEmail, $isAdmin, $emailToDelete)) {
        http_response_code(403); // Forbidden
        echo "Access denied. You do not have permission to delete this user.";
        exit;
    }

    try {
        if (deleteUser($emailToDelete)) {
            http_response_code(200); // OK
            echo "User deleted successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while deleting the user.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
