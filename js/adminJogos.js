const modalJogoElement = document.getElementById('modalJogo');
const modalJogo = new bootstrap.Modal(modalJogoElement);

function deleteGame(GameId) {
    const formData = new FormData();
    formData.append('id', GameId);
    fetch('/admin/jogos/deleteGame.php', {
        method: 'POST',
        body: formData
    })
        .then(response => handleResponse(response))
        .catch(error => handleError(error));
}

const GameForm = document.getElementById('game-form');

GameForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(GameForm);
    const action = GameForm.dataset.action;
    const url = action === 'edit' ? '/admin/jogos/updateGame.php' : '/admin/jogos/addGame.php';

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
        modalJogo.hide();
        handleResponse(response)
    })
        .catch(error => handleError(error));
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="delete"][data-target="jogo"]').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.targetId;
            deleteGame(targetId);

        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="edit"][data-target="jogo"]').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.targetId;
            const nome = this.dataset.nome;
            const dificuldade = this.dataset.dificuldade;
            const animais = JSON.parse(this.dataset.animais).map(animal => animal.id);


            // Populate the form with the Game's data
            const form = document.getElementById('game-form');

            const idInput = form.querySelector('[name="id"]')
            idInput.value = id;

            const nomeInput = form.querySelector('[name="nome"]')
            nomeInput.value = nome;

            const dificuldadeInput = form.querySelector('[name="dificuldade"]')
            dificuldadeInput.value = dificuldade;

            const animaisInput = form.querySelectorAll('[name="animais[]"]')
            console.log(animaisInput, animais);
            animaisInput.forEach(checkbox => {
                // Check the checkbox if its value is in the animaisIds array
                if (animais.includes(parseInt(checkbox.value))) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });


            form.dataset.action = 'edit';

            modalJogoElement.querySelector(".modal-title").innerHTML = "Editar usuário";
            modalJogoElement.querySelector(".modal-footer").querySelector("button[type='submit']").innerHTML = "Salvar alterações";

            modalJogo.show();

        });
    });
});