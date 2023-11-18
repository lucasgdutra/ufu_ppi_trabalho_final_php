<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$animals_array = [];
require_once "../classes/Database.php";
try {
  // Pass the desired database dialect while creating the object
  $database = new Database('mysql'); // Could be 'mysql', 'mariadb', 'pgsql', 'sqlite', etc.
  $conn = $database->getConnection();

  // SQL query to fetch data from animals table
  $sql = "SELECT * FROM animais order by nome";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $animals_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  "/css/lista.css",
];
include '../includes/navbar.php';
?>
<main class="container">
  <div class="my-5">
    <form class="d-flex mb-3" role="search" id="search-form">
      <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar" />
      <button class="btn btn-outline-success" type="submit">
        Pesquisar
      </button>
    </form>
    <div>
      <?php foreach ($animals_array as $animal) : ?>
        <div class="card mb-3">
          <div class="row g-0 h-100">
            <div class="col-md-4 h-100">
              <img src="/img/animais/<?= $animal['imagem_url'] ?>-grande.webp" class="img-fluid rounded-start" alt="imagem de <?= $animal['nome'] ?>" width="450" height="300" loading="lazy" decoding="async" />
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $animal['nome'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                  Nome Cientifico: <?= $animal['nome_cientifico'] ?>
                </h6>
                <h6 class="card-subtitle mb-2 text-muted">Classe: <?= $animal['classe'] ?></h6>
                <h6 class="card-subtitle mb-2 text-muted">
                  Número de individuos: <?= $animal['numero_individuos'] ?>
                </h6>
                <span class="badge text-bg-<?php echo ($animal['risco_extincao'] == 'Alto' ? 'danger' : ($animal['risco_extincao'] == 'Médio' ? 'warning' : 'success')) ?>">Risco de extinção <?= $animal['risco_extincao'] ?></span>
                <p class="card-text">
                  <?= $animal['descricao'] ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>


<?php
$scripts = [
  "/js/lista.js",
];
include '../includes/footer.php';

?>