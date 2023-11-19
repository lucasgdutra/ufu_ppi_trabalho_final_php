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


$jogosSql = "SELECT
	j.id,
	j.nome,
    j.id_dificuldade,
	d.nome as dificuldade
FROM
	jogos j left join dificuldade d on j.id_dificuldade = d.id
order by
	d.id asc, j.nome";
$stmt = $conn->prepare($jogosSql);
$stmt->execute();
$jogos = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($jogos as $key => $jogo) {
    $jogos[$key]['animais'] = getAnimalsByGameId($jogo['id']);
}

$dificuldadeSql = "SELECT id, nome FROM dificuldade order by id asc";
$stmtDificuldade = $conn->prepare($dificuldadeSql);
$stmtDificuldade->execute();
$dificuldades = $stmtDificuldade->fetchAll(PDO::FETCH_ASSOC);

function getAnimalsByGameId($gameId)
{
    global $conn;
    $sql = "SELECT a.id FROM animais a
            JOIN relacoes_animais_jogos r ON a.id = r.id_animal
            WHERE r.id_jogo = :gameId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':gameId', $gameId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!-- Games Section -->
<h2 class="mb-3">Jogos</h2>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJogo">
    Novo Jogo
</button>
<div class="modal fade" id="modalJogo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Jogo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="game-form" data-action="add" class="mb-3">
                <div class="modal-body">
                    <input type="hidden" name="id" />
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" placeholder="nome" name="nome" required />
                    </div>

                    <div class="mb-3">
                        <label for="dificuldade" class="form-label">Dificuldade</label>
                        <select class="form-select" aria-label="Dificuldade" name="dificuldade">
                            <?php foreach ($dificuldades as $dificuldade) : ?>
                                <option value="<?php echo $dificuldade['id'] ?>"><?php echo $dificuldade['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 container">
                        <label for="Animais" class="form-label">Animais</label>
                        <div class="row">
                            <?php foreach ($animais as $animal) : ?>


                                <div class="form-check form-switch col-12 col-sm-6 col-md-4 col-xl-3 text-truncate">
                                    <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($animal['id']); ?>" role="switch" name="animais[]" />
                                    <label class="form-check-label " for="<?php echo htmlspecialchars($animal['nome']); ?>"><?php echo htmlspecialchars($animal['nome']); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success">
                        Adicionar
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </form>
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

                    <button class="btn btn-secondary btn-sm me-2" data-action="edit" data-target="jogo" data-target-id="<?php echo htmlspecialchars($jogo['id']); ?>" data-nome="<?php echo htmlspecialchars($jogo['nome']); ?>" data-dificuldade="<?php echo htmlspecialchars($jogo['id_dificuldade']); ?>" data-animais="<?php echo htmlspecialchars(json_encode($jogo['animais'])); ?>">
                        Editar
                    </button>



                    <button class="btn btn-danger btn-sm" data-action="delete" data-target="jogo" data-target-id="<?php echo $jogo['id']; ?>">Deletar</button>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>