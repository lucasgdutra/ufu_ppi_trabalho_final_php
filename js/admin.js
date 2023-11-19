const infoModalElement = document.getElementById('infoModal');
const infoModal = new bootstrap.Modal(infoModalElement);
function reloadPage() {
  console.log('reload')
  window.location.href = window.location.href;
}
const confirmationButton = infoModalElement.querySelector(".modal-footer .confirmation-button");
confirmationButton.innerHTML = "OK";
confirmationButton.addEventListener('click', reloadPage);


// General response handler
function handleResponse(response) {
  if (response.ok) {
    if (response.status === 200 || response.status === 201) {
      // Update title and body of the modal
      infoModalElement.querySelector(".modal-title").innerHTML = "Operação realizada com sucesso";
      infoModalElement.querySelector(".modal-body").innerHTML = "Recarregar a página para carregar alterações?";

      // Show the modal
      infoModal.show();
    }
    return response.text();
  } else {
    // Error handling based on status code
    switch (response.status) {
      case 400:
        alert("Requisição inválida. Por favor, verifique os dados e tente novamente.");
        break;
      case 401:
        alert("Não autorizado. Faça login e tente novamente.");
        break;
      case 403:
        alert("Você não tem permissão para realizar esta ação.");
        break;
      case 405:
        alert("Método não permitido. Verifique o método da requisição.");
        break;
      case 409:
        alert("Conflito. Recurso já existe.");
        break;
      case 500:
        alert("Erro interno do servidor. Tente novamente mais tarde.");
        break;
      default:
        alert("Ocorreu um erro. Tente novamente mais tarde.");
    }
    throw new Error('HTTP status ' + response.status);
  }
}

// General error handler
function handleError(error) {
  console.error('Error:', error);

}
