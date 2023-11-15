<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

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




$alert_type = "";
$alert_message = "";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include your database connection script
  require_once "../classes/Database.php";
  $email = $_POST['email'];
  $password = $_POST['password'];

  try {
    $database = new Database('mysql');
    $conn = $database->getConnection();

    // Prepare SQL statement to fetch the user
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verify password (assuming passwords are stored securely)
      if (password_verify($password, $user['senha'])) {
        // Password is correct, start a session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_is_admin'] = (bool)$user['isAdmin'];
        // Redirect to a logged-in page
        header("Location: /jogos");
        exit();
      } else {
        $alert_type = "danger";
        $alert_message = "Usuário ou senha incorretos.";
      }
    } else {
      $alert_type = "danger";
      $alert_message = "Usuário ou senha incorretos.";
    }

    $database->closeConnection();
  } catch (\PDOException $e) {
    $alert_type = "danger";
    $alert_message =
      "Database connection failed: " . $e->getMessage();
  }
}
?>

<?php
$links = ["/css/login.css"];
include '../includes/navbar.php'; ?>
<main class="container">
  <?php if ($alert_type != '') { ?>

    <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
      <?php echo htmlspecialchars($alert_message); ?>
    </div>
  <?php } ?>
  <form id="form-login" action="/login/index.php" method="post">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
      <input type="email" class="form-control" id="email" name="email" />
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Senha</label>
      <input type="password" class="form-control" id="password" name="password" />
    </div>
    <div class="form-text">
      Não tem uma conta? Crie uma clicando
      <a href="/cadastro">aqui</a>
    </div>

    <button type="submit" class="btn btn-primary">Entrar</button>
  </form>
</main>
<?php
$scripts = ["/js/login.js"];
include '../includes/footer.php'; ?>