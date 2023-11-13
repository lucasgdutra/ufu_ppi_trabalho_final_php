document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#form-login");
  if (!form) return;
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    var formData = new FormData(document.getElementById('form-login'));

    fetch('handleForm.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())
      .then(data => {
        console.log(data); // Handle the response data
        // You can also update the UI here to show success or error messages
      })
      .catch(error => {
        console.error('Error:', error);
      });
  });
});




