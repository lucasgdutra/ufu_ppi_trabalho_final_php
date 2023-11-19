<?php
// CREATE TABLE `usuarios` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `nome` varchar(255) DEFAULT NULL,
//   `senha` char(255) DEFAULT NULL,
//   `pontos` int(11) DEFAULT NULL,
//   `email` varchar(255) DEFAULT NULL,
//   `imagem` blob DEFAULT NULL,
//   `isAdmin` tinyint(1) DEFAULT NULL,
//   `recorde_segundos` int(11) DEFAULT NULL,
//   PRIMARY KEY (`id`)
// )

$usuarios_array = [];
require_once "../classes/Database.php";
try {
  $database = new Database('mysql');
  $conn = $database->getConnection();

  // Modify the SQL query to order users by points and then by record time
  $sql = "SELECT * FROM usuarios ORDER BY pontos DESC, recorde_segundos ASC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $usuarios_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $database->closeConnection();
} catch (\PDOException $e) {
  echo "Database connection failed: " . $e->getMessage();
} catch (\InvalidArgumentException $e) {
  echo "Invalid database dialect: " . $e->getMessage();
}
?>
<?php include '../includes/navbar.php'; ?>
<main class="container">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Posição</th>
        <th scope="col">Nome</th>
        <th scope="col">Pontos</th>
        <th scope="col">Recorde de tempo</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Initialize position counter
      $position = 1;

      // Iterate through the users array to populate the table
      foreach ($usuarios_array as $usuario) {
        echo "<tr>";
        echo "<th scope='row'>" . $position++ . "</th>";
        echo "<td>" . htmlspecialchars($usuario['nome']) . "</td>";
        echo "<td>" . $usuario['pontos'] . "</td>";
        echo "<td>" . ($usuario['recorde_segundos'] != null ? gmdate("i:s", $usuario['recorde_segundos']) : '-') . "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</main>
<?php include '../includes/footer.php'; ?>