const modalUsuarioElement = document.getElementById('modalUsuario');
const modalUsuario = new bootstrap.Modal(modalUsuarioElement);

function deleteUser(userId) {
    const formData = new FormData();
    formData.append('email', userId);
    fetch('/admin/usuarios/deleteUser.php', {
        method: 'POST',
        body: formData
    })
        .then(response => handleResponse(response))
        .catch(error => handleError(error));
}

const userForm = document.getElementById('user-form');
const isAdminCheckbox = document.getElementById('isAdmin');
userForm.addEventListener("submit", function (e) {
    e.preventDefault();
    isAdminCheckbox.value = isAdminCheckbox.checked ? 'true' : 'false';
    const formData = new FormData(userForm);
    const action = userForm.dataset.action;
    const url = action === 'edit' ? '/admin/usuarios/updateUser.php' : '/admin/usuarios/addUser.php';

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
        modalUsuario.hide();
        handleResponse(response)
    })
        .catch(error => handleError(error));
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="delete"][data-target="usuario"]').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.targetId;
            deleteUser(targetId);

        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('[data-action="edit"][data-target="usuario"]').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.targetId;
            const userName = this.dataset.nome;
            const userEmail = this.dataset.email;
            const userIsAdmin = this.dataset.isadmin === 'true';

            // Populate the form with the user's data
            const form = document.getElementById('user-form');
            form.querySelector('[name="email"]').value = userEmail;
            form.querySelector('[name="nome"]').value = userName;
            const senhaInput = form.querySelector('[name="senha"]');
            senha.value = ''; // Clear the password field
            senhaInput.required = false; // Remove the required attribute

            form.querySelector('[name="isAdmin"]').checked = userIsAdmin;
            form.dataset.action = 'edit';

            modalUsuarioElement.querySelector(".modal-title").innerHTML = "Editar usuário";
            modalUsuarioElement.querySelector(".modal-footer").querySelector("button[type='submit']").innerHTML = "Salvar alterações";

            modalUsuario.show();

        });
    });
});