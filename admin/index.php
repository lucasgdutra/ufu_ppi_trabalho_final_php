<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
  // Redirect to login page or show an error message
  header('Location: /jogos');
  exit;
}

$links = ["/css/admin.css"];
include '../includes/navbar.php';
?>
<main class="container">
  <div class="container mt-5">
    <?php include_once 'usuarios/index.php'; ?>

    <?php include_once 'animais/index.php'; ?>

    <?php include_once 'jogos/index.php'; ?>

  </div>
  <div class="modal" tabindex="-1" id="infoModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary confirmation-button">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
$scripts = ["/js/admin.js", "/js/adminUsuarios.js", "/js/adminAnimais.js", "/js/adminJogos.js"];
include '../includes/footer.php'; ?>