<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$animals_array = [];
require_once "../classes/Database.php";

$nome = isset($_GET['nome']) ? $_GET['nome'] : ''; // Retrieve the 'nome' query parameter

try {
  // Pass the desired database dialect while creating the object
  $database = new Database('mysql'); // Could be 'mysql', 'mariadb', 'pgsql', 'sqlite', etc.
  $conn = $database->getConnection();

  // SQL query to fetch data from animals table
  $sql = "SELECT animais.* FROM animais
            INNER JOIN relacoes_animais_jogos ON animais.id = relacoes_animais_jogos.id_animal
            INNER JOIN jogos ON jogos.id = relacoes_animais_jogos.id_jogo
            WHERE jogos.nome = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$nome]);


  $animals_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (empty($animals_array)) {
    header("Location: /jogos");
    exit;
  }
  $animals_array = array_merge($animals_array, $animals_array);  // Duplicate the array to have 2 of each animal

  shuffle($animals_array); // Shuffle the array

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
$links = ["/css/jogo.css"];
include '../includes/navbar.php'; ?>
<main class="container">
  <div class="mt-5 d-flex flex-row justify-content-between">
    <h5>Pares encontrados: <span id="score">0</span></h5>
    <h5>Quantidade de movimentos: <span id="moves">0</span></h5>
    <h5>Tempo: <span id="time">00:00</span></h5>
  </div>
  <div class="d-flex gap-1 justify-content-evenly my-5 flex-wrap">
    <?php foreach ($animals_array as $animal) : ?>
      <div class="flip-card">
        <div class="card flip-card-inner" data-animal-id="<?= $animal['nome'] ?>">
          <div class="flip-card-back">
            <img src="/img/animais/<?= $animal['imagem_url'] ?>-pequeno.webp" class="card-img-top" alt="imagem de <?= $animal['nome'] ?>" width="333" height="250" />
            <div class="card-body p-1 pt-0 text-truncate">
              <h5 class="card-title"><?= $animal['nome'] ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?= $animal['nome_cientifico'] ?></h6>
              <h6 class="card-subtitle mb-2 text-muted"><?= $animal['classe'] ?></h6>
              <span class="badge text-bg-<?php echo ($animal['risco_extincao'] == 'Alto' ? 'danger' : ($animal['risco_extincao'] == 'Médio' ? 'warning' : 'success')) ?>">Risco de Extinção <?= $animal['risco_extincao'] ?></span>
            </div>
          </div>
          <div class="flip-card-front d-flex flex-column justify-content-start">
            <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" />

            <!-- <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span> -->
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</main>
<?php
$scripts = [
  "/js/jogo.js",
];
include '../includes/footer.php'; ?>