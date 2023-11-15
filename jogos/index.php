<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
// create table jogos (
// id int(11) NOT NULL AUTO_INCREMENT,
// nome varchar(255) DEFAULT NULL,
// dificuldade varchar(255) DEFAULT NULL,
// PRIMARY KEY (id)
// )
$jogos_array = [];
require_once "../classes/Database.php";
try {
  // Pass the desired database dialect while creating the object
  $database = new Database('mysql'); // Could be 'mysql', 'mariadb', 'pgsql', 'sqlite', etc.
  $conn = $database->getConnection();

  // SQL query to fetch data from animals table
  $sql = "SELECT * FROM jogos";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $jogos_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Remember to close the connection if it's no longer needed
  $database->closeConnection();
} catch (\PDOException $e) {
  // Handle the exception
  echo "Database connection failed: " . $e->getMessage();
} catch (\InvalidArgumentException $e) {
  // Handle the exception for unsupported dialects
  echo "Invalid database dialect: " . $e->getMessage();
}
?>
<?php
$links = [
  "/css/jogos.css",
];
include '../includes/navbar.php'; ?>
<main class="container">
  <div class="d-flex gap-3 justify-content-evenly mt-5 flex-wrap">
    <?php foreach ($jogos_array as $jogo) : ?>
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title"><?= $jogo['nome'] ?></h5>
          <h6 class="card-subtitle mb-2 text-body-secondary"><?= $jogo['dificuldade'] ?></h6>
          <a href="/jogo?nome=<?= $jogo['nome'] ?>" class="card-link">Jogar</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>
<?php include '../includes/footer.php'; ?>