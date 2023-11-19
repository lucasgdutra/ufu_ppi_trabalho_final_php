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


function updateGame($id, $nome, $dificuldade)
{
    global $conn;
    // Start building the SQL query
    $sql = "UPDATE jogos SET ";
    $params = [];
    $updateFields = [];

    if (!empty($nome)) {
        $updateFields[] = "nome = :nome";
        $params[':nome'] = $nome;
    }

    if (!empty($dificuldade)) {
        $updateFields[] = "id_dificuldade = :dificuldade";
        $params[':dificuldade'] = $dificuldade;
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

function updateAnimalsForGame($gameId, $animais)
{
    global $conn;
    // First, remove existing associations
    $deleteSql = "DELETE FROM relacoes_animais_jogos WHERE id_jogo = :id_jogo";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bindParam(':id_jogo', $gameId);
    $stmt->execute();

    // Now, add new associations
    $insertSql = "INSERT INTO relacoes_animais_jogos (id_jogo, id_animal) VALUES (:id_jogo, :id_animal)";
    foreach ($animais as $animal) {
        $stmt = $conn->prepare($insertSql);
        $stmt->bindParam(':id_jogo', $gameId);
        $stmt->bindParam(':id_animal', $animal);
        $stmt->execute();
    }
}

function checkIfGameExists($id)
{
    global $conn;
    $sql = "SELECT * FROM jogos WHERE id = :id";

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


    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $dificuldade = $_POST['dificuldade'] ?? '';



    if (empty($id)) {
        http_response_code(400); // Bad Request
        echo "id is required.";
        exit;
    }



    try {

        if (!checkIfGameExists($id)) {
            http_response_code(404); // Not Found
            echo "Game not found.";
            exit;
        }
        if (updateGame($id, $nome, $dificuldade)) {
            $animais = $_POST['animais'] ?? [];
            updateAnimalsForGame($id, $animais);

            http_response_code(200); // OK
            echo "Game and animals updated successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while updating the Game.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
