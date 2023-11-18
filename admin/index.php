<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
  // Redirect to login page or show an error message
  header('Location: /jogos');
  exit;
}

require_once "../classes/Database.php";

$database = new Database('mysql');
$conn = $database->getConnection();


$usersSql = "SELECT id, nome FROM usuarios order by nome asc";
$stmt = $conn->prepare($usersSql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$animaisSql = "SELECT id, nome FROM animais order by nome asc";
$stmt = $conn->prepare($animaisSql);
$stmt->execute();
$animais = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jogosSql = "SELECT id, nome FROM jogos order by nome asc";
$stmt = $conn->prepare($jogosSql);
$stmt->execute();
$jogos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$links = ["/css/admin.css"];
include '../includes/navbar.php';
?>
<main class="container">
  <div class="container mt-5">
    <h2 class="mb-3">Usuários</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">
      Novo Usuário
    </button>
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Usuário</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="user-form">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="email" name="email" required />
              </div>
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" placeholder="nome" name="nome" required />
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" required />
              </div>
              <div class="mb-3">
                <label for="profilePhoto" class="form-label">Foto de perfil</label>
                <input class="form-control" type="file" id="profilePhoto" />
              </div>
              <button type="submit" class="btn btn-outline-success">
                Adicionar
              </button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              Fechar
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody id="user-table">
        <?php foreach ($users as $user) : ?>
          <tr>
            <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
            <td><?php echo htmlspecialchars($user['nome']); ?></td>
            <td>
              <button class="btn btn-secondary btn-sm me-2">Editar</button>
              <button class="btn btn-danger btn-sm">Deletar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Animals Section -->
    <h2 class="mb-3">Animais</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAnimal">
      Novo Animal
    </button>
    <div class="modal fade" id="modalAnimal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Animal</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="animal-form" class="mb-3"></form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" placeholder="nome" required />
            </div>
            <div class="mb-3">
              <label for="nome-cientifico" class="form-label">Nome Cientifico</label>
              <input type="text" class="form-control" placeholder="nome-cientifico" required />
            </div>
            <div class="mb-3">
              <label for="quantidade-individuos" class="form-label">Quantidade de individuos</label>
              <input type="number" name="quantidade-individuos" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="classe" class="form-label">Classe</label>
              <select class="form-select" aria-label="classe">
                <option value="Mamifero">Mamifero</option>
                <option value="Ave">Ave</option>
                <option value="Reptil">Reptil</option>
                <option value="Anfibio">Anfibio</option>
                <option value="Peixe">Peixe</option>
                <option value="Invertebrados">Invertebrados</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea name="descricao" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-outline-success">
              Adicionar
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              Fechar
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody id="animals-table">
        <?php foreach ($animais as $animal) : ?>
          <tr>
            <th scope="row"><?php echo htmlspecialchars($animal['id']); ?></th>
            <td><?php echo htmlspecialchars($animal['nome']); ?></td>
            <td>
              <button class="btn btn-secondary btn-sm me-2">Editar</button>
              <button class="btn btn-danger btn-sm">Deletar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Games Section -->
    <h2 class="mb-3">Jogos</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJogo">
      Novo Jogo
    </button>
    <div class="modal fade" id="modalJogo" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Jogo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="game-form" class="mb-3"></form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" placeholder="nome" required />
            </div>

            <div class="mb-3">
              <label for="Dificuldade" class="form-label">Dificuldade</label>
              <select class="form-select" aria-label="Dificuldade">
                <option value="facil">Fácil</option>
                <option value="medio">Médio</option>
                <option value="dificil">Díficil</option>
              </select>
            </div>
            <div class="mb-3 container">
              <label for="Animais" class="form-label">Animais</label>
              <div class="row">
                <?php foreach ($animais as $animal) : ?>


                  <div class="form-check form-switch col-12 col-sm-6 col-md-4 col-xl-3 text-truncate">
                    <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($animal['nome']); ?>" role="switch" name="animais[]" />
                    <label class="form-check-label " for="<?php echo htmlspecialchars($animal['nome']); ?>"><?php echo htmlspecialchars($animal['nome']); ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <button type="submit" class="btn btn-outline-success">
              Adicionar
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              Fechar
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody id="animals-table">
        <?php foreach ($jogos as $jogo) : ?>
          <tr>
            <th scope="row"><?php echo htmlspecialchars($jogo['id']); ?> </th>
            <td><?php echo htmlspecialchars($jogo['nome']); ?></td>

            <td>
              <button class="btn btn-secondary btn-sm me-2">Editar</button>
              <button class="btn btn-danger btn-sm">Deletar</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php
$scripts = ["/js/admin.js"];
include '../includes/footer.php'; ?>