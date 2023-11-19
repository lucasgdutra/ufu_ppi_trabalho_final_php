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



function addGame($nome, $id_dificuldade)
{
    global $conn;
    $sql = "INSERT INTO jogos (nome, id_dificuldade) VALUES (:nome, :id_dificuldade)";

    try {

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id_dificuldade', $id_dificuldade);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

function addAnimalsToGame($gameId, $animais)
{
    global $conn;
    $sql = "INSERT INTO relacoes_animais_jogos (id_jogo, id_animal) VALUES (:id_jogo, :id_animal)";

    foreach ($animais as $animal) {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_jogo', $gameId);
        $stmt->bindParam(':id_animal', $animal);
        $stmt->execute();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database('mysql');
    $conn = $database->getConnection();


    $nome = $_POST['nome'] ?? '';
    $dificuldade = $_POST['dificuldade'] ?? '';



    if (empty($nome) || empty($dificuldade)) {
        http_response_code(400); // Bad Request
        echo "All fields are required.";
        exit;
    }

    try {

        $gameId = addGame($nome, $dificuldade);

        if ($gameId) {
            $animais = $_POST['animais'] ?? [];
            addAnimalsToGame($gameId, $animais);

            http_response_code(201); // Created
            echo "Game and animals registered successfully";
        } else {
            http_response_code(500); // Internal Server Error
            echo "An error occurred while registering the game.";
        }
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
