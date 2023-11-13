document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("search-form");
  if (!form) return;
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    const search = form.querySelector("input")?.value;
    if (!search) {
      const cards = document.querySelectorAll(".card");
      cards.forEach(function (card) {
        card.classList.remove("d-none");
      });
      return;
    }
    const cards = document.querySelectorAll(".card");
    cards.forEach(function (card) {
      const name = card.querySelector(".card-title")?.textContent;
      if (!name) return;
      if (name.toLowerCase().includes(search.toLowerCase())) {
        card.classList.remove("d-none");
      } else {
        card.classList.add("d-none");
      }
    });
  });
});
