<?php
$links = ["/css/cadastro.css"];
include '../includes/navbar.php'; ?>
<main class="container">
  <form id="form-login" action="handleForm.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
      <input type="email" class="form-control" id="email" name="email" required />
    </div>
    <div class="mb-3">
      <label for="nome" class="form-label">Nome</label>
      <input type="text" class="form-control" name="nome" required />
    </div>
    <div class="mb-3">
      <label for="senha" class="form-label">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" required />
    </div>
    <div class="mb-3">
      <label for="profilePhotoFile" class="form-label">Foto de perfil</label>
      <input class="form-control" type="file" id="profilePhotoFile" name="profilePhoto" />
    </div>

    <button type="submit" class="btn btn-primary">Criar conta</button>
  </form>
</main>


<?php
$scripts = ["/js/cadastro.js"];
include '../includes/footer.php'; ?>