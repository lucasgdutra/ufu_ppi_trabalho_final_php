<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
    // Redirect to login page or show an error message
    header('Location: /jogos');
    exit;
}

require_once "../classes/Database.php"; //como o arquivo é incluido um nivel acima, é necessário voltar um nivel para acessar a pasta classes

$database = new Database('mysql');
$conn = $database->getConnection();


$usersSql = "SELECT id, nome, email, isAdmin FROM usuarios order by nome asc";
$stmt = $conn->prepare($usersSql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
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
            <form id="user-form" data-action="add">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="email" name="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" placeholder="nome" name="nome" required />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required />
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="isAdmin" name="isAdmin">
                        <label class="form-check-label" for="isAdmin">
                            Administrador
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="profilePhotoFile" class="form-label">Foto de perfil</label>
                        <input class="form-control" type="file" id="profilePhotoFile" name="profilePhoto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success">
                        Adicionar
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Administrador</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody id="user-table">
        <?php foreach ($users as $user) : ?>
            <tr>
                <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
                <td><?php echo htmlspecialchars($user['nome']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['isAdmin'] ? "Sim" : "Não"); ?></td>
                <td>
                    <button class="btn btn-secondary btn-sm me-2" data-action="edit" data-target="usuario" data-target-id="<?php echo $user['id']; ?>" data-nome="<?php echo htmlspecialchars($user['nome']); ?>" data-email="<?php echo htmlspecialchars($user['email']); ?>" data-isadmin="<?php echo $user['isAdmin'] ? 'true' : 'false'; ?>">Editar</button>
                    <button class="btn btn-danger btn-sm" data-action="delete" data-target="usuario" data-target-id="<?php echo $user['email']; ?>">Deletar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>