const modalAnimalElement = document.getElementById('modalAnimal');
const modalAnimal = new bootstrap.Modal(modalAnimalElement);

function deleteAnimal(AnimalId) {
    const formData = new FormData();
    formData.append('id', AnimalId);
    fetch('/admin/animais/deleteAnimal.php', {
        method: 'POST',
        body: formData
    })
        .then(response => handleResponse(response))
        .catch(error => handleError(error));
}

const AnimalForm = document.getElementById('animal-form');

AnimalForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(AnimalForm);
    const action = AnimalForm.dataset.action;
    const url = action === 'edit' ? '/admin/animais/updateAnimal.php' : '/admin/animais/addAnimal.php';

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
        modalAnimal.hide();
        handleResponse(response)
    })
        .catch(error => handleError(error));
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="delete"][data-target="animal"]').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.targetId;
            deleteAnimal(targetId);

        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="edit"][data-target="animal"]').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.targetId;
            const nome = this.dataset.nome;
            const nomeCientifico = this.dataset.nomeCientifico;
            const quantidadeIndividuos = this.dataset.quantidadeIndividuos;
            const classe = this.dataset.classe;
            const descricao = this.dataset.descricao;


            // Populate the form with the Animal's data
            const form = document.getElementById('animal-form');
            form.dataset.action = 'edit';

            const idInput = form.querySelector('[name="id"]');
            idInput.value = id;

            const nomeInput = form.querySelector('[name="nome"]')
            nomeInput.value = nome;
            nomeInput.required = false;

            const nomeCientificoInput = form.querySelector('[name="nome-cientifico"]')
            nomeCientificoInput.value = nomeCientifico;
            nomeCientificoInput.required = false;

            const quantidadeIndividuosInput = form.querySelector('[name="quantidade-individuos"]')
            quantidadeIndividuosInput.value = quantidadeIndividuos;
            quantidadeIndividuosInput.required = false;


            const classeInput = form.querySelector('[name="classe"]')
            classeInput.value = classe;
            classeInput.required = false;

            const descricaoInput = form.querySelector('[name="descricao"]')
            descricaoInput.value = descricao;
            descricaoInput.required = false;

            modalAnimalElement.querySelector(".modal-title").innerHTML = "Editar animal";
            modalAnimalElement.querySelector(".modal-footer").querySelector("button[type='submit']").innerHTML = "Salvar alterações";

            modalAnimal.show();

        });
    });
});