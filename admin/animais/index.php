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


$animaisSql = "SELECT * FROM animais order by nome asc";
$stmt = $conn->prepare($animaisSql);
$stmt->execute();
$animais = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
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
            <form id="animal-form" data-action="add" class="mb-3">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" />
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" placeholder="nome" name="nome" id="nome" required />
                    </div>
                    <div class="mb-3">
                        <label for="nome-cientifico" class="form-label">Nome Cientifico</label>
                        <input type="text" class="form-control" placeholder="nome-cientifico" name="nome-cientifico" id="nome-cientifico" required />
                    </div>
                    <div class=" mb-3">
                        <label for="quantidade-individuos" class="form-label">Quantidade de individuos</label>
                        <input type="number" class="form-control" name="quantidade-individuos" id="quantidade-individuos" />
                    </div>
                    <div class="mb-3">
                        <label for="risco-extincao" class="form-label">Risco de Extinção</label>
                        <select class="form-select" aria-label="risco-extincao" name="risco-extincao" id="risco-extincao">
                            <option value="Baixo">Baixo</option>
                            <option value="Médio">Médio</option>
                            <option value="Alto">Alto</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="classe" class="form-label">Classe</label>
                        <select class="form-select" aria-label="classe" name="classe" id="classe">
                            <option value="Mamífero">Mamífero</option>
                            <option value="Ave">Ave</option>
                            <option value="Réptil">Réptil</option>
                            <option value="Anfíbio">Anfíbio</option>
                            <option value="Peixe">Peixe</option>
                            <option value="Molusco">Molusco</option>
                            <option value="Invertebrados">Invertebrados</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="animalPhotoFile" class="form-label">Foto do animal</label>
                        <input class="form-control" type="file" id="animalPhotoFile" name="animalPhoto">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" cols="30" rows="10" class="form-control" id="descricao"></textarea>
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
        <?php foreach ($animais as $animal) : ?>
            <tr>
                <th scope="row"><?php echo htmlspecialchars($animal['id']); ?></th>
                <td><?php echo htmlspecialchars($animal['nome']); ?></td>
                <td>
                    <button class="btn btn-secondary btn-sm me-2" data-action="edit" data-target="animal" data-target-id="<?php echo $animal['id']; ?>" data-nome="<?php echo $animal['nome'] ?>" data-nome-cientifico="<?php echo $animal['nome_cientifico'] ?>" data-quantidade-individuos="<?php echo $animal['numero_individuos'] ?>" data-classe="<?php echo $animal['classe'] ?>" data-descricao="<?php echo $animal['descricao'] ?>">
                        Editar
                    </button>
                    <button class="btn btn-danger btn-sm" data-action="delete" data-target="animal" data-target-id="<?php echo $animal['id']; ?>">Deletar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>