<?php
$links = ["/css/login.css"];
include '../includes/navbar.php'; ?>
<main class="container">
  <form id="form-login">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
      <input type="email" class="form-control" id="email" required />
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Senha</label>
      <input type="password" class="form-control" id="password" required />
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