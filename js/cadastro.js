document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#form-login");
  if (!form) return;
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    var formData = new FormData(document.getElementById('form-login'));

    fetch('/admin/usuarios/addUser.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.ok) {
          if (response.status === 201) {
            alert("Cadastro feito com sucesso");
          }
          return response.text();
        } else {
          switch (response.status) {
            case 400:
              alert("Requisição inválida. Por favor, verifique os dados e tente novamente.");
              break;
            case 401:
              alert("Não autorizado. Faça login e tente novamente.");
              break;
            case 405:
              alert("Método não permitido. Verifique o método da requisição.");
              break;
            case 409:
              alert("Conflito. Usuário já existe.");
              break;
            case 500:
              alert("Erro interno do servidor. Tente novamente mais tarde.");
              break;
            default:
              alert("Ocorreu um erro. Tente novamente mais tarde.");
          }
          throw new Error('HTTP status ' + response.status);
        }
      })
      .then(data => {
        console.log(data); // You can handle the data/response further here
      })
      .catch(error => {
        console.error('Error:', error);
        // You can also update the UI here to show error messages
      });
  });
});
