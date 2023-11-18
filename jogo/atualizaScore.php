<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "../classes/Database.php"; // Adjust the path as needed

    // Check if a session is active
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $gamePoints = $_POST['game_points'] ?? '';
        $gameTime = $_POST['game_time'] ?? 0;

        try {
            $database = new Database('mysql');
            $conn = $database->getConnection();

            // Increment points
            $updatePointsSql = "UPDATE usuarios SET pontos = pontos + :gamePoints WHERE id = :userId";
            $stmt = $conn->prepare($updatePointsSql);

            // Ensure that $gamePoints is an integer
            $gamePoints = (int) $gamePoints;

            $stmt->bindParam(':gamePoints', $gamePoints, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            $stmt->execute();


            // Check and update record time if applicable
            $checkTimeSql = "SELECT recorde_segundos FROM usuarios WHERE id = ?";
            $stmt = $conn->prepare($checkTimeSql);
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && ($user['recorde_segundos'] === null || $gameTime < $user['recorde_segundos'])) {
                $updateTimeSql = "UPDATE usuarios SET recorde_segundos = ? WHERE id = ?";
                $stmt = $conn->prepare($updateTimeSql);
                $stmt->execute([$gameTime, $userId]);
            }

            $database->closeConnection();
            http_response_code(200);
            echo "Ranking Atualizado com sucesso.";
        } catch (\PDOException $e) {
            http_response_code(500);
            echo "Database error: " . $e->getMessage();
        }
    } else {
        http_response_code(401);
        echo "401 Unauthorized: No active session.";
    }
} else {
    http_response_code(405);
    echo "405 Method Not Allowed";
}
