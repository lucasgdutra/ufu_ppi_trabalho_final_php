document.addEventListener("DOMContentLoaded", () => {
  let score = 0;
  let time = 0;
  let moves = 0;
  let timerInterval;

  function syncScore() {
    const scoreElement = document.querySelector("#score");
    if (scoreElement) {
      scoreElement.innerHTML = score.toString();
    }
  }

  function syncMoves() {
    const movesElement = document.querySelector("#moves");
    if (movesElement) {
      movesElement.innerHTML = moves.toString();
    }
  }

  function syncTime() {
    const minutes = Math.floor(time / 60)
      .toString()
      .padStart(2, "0");
    const seconds = (time % 60).toString().padStart(2, "0");
    const timeElement = document.querySelector("#time");
    if (timeElement) {
      timeElement.innerHTML = `${minutes}:${seconds}`;
    }
  }

  function updateGameResult(gamePoints, gameTime) {
    const formData = new FormData();
    formData.append('game_points', gamePoints);
    formData.append('game_time', gameTime);

    fetch('/jogo/atualizaScore.php', { // Update the path as needed
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.status === 401) {
          throw new Error('Faça login para pontuar no ranking');
        }
        return response.text();
      })
      .then(result => alert(result))
      .catch(error => {
        console.error('Error:', error);
        if (error.message === 'Faça login para pontuar no ranking') {
          alert('Faça login para pontuar no ranking');
        }
      });
  }




  function checkGameEnd() {
    const totalCards = document.querySelectorAll(".flip-card-inner").length;
    const blockedCards = document.querySelectorAll(
      ".flip-card-inner.blocked"
    ).length;
    if (blockedCards === totalCards) {
      clearInterval(timerInterval); // Stop the timer
      alert("Jogo finalizado!"); // Alert the user
      const gamePoints = Math.ceil(score - moves / 10); // Calculate the game points
      updateGameResult(gamePoints, time);
    }
  }

  let flippedCards = [];
  function flipCard(card) {
    // If the clicked card is already flipped, do nothing
    if (
      card.classList.contains("fliped") ||
      card.classList.contains("blocked")
    ) {
      return;
    }

    moves++;
    syncMoves();

    // If two cards are already flipped, unflip them and reset the flippedCards array
    if (flippedCards.length === 2) {
      const [card1, card2] = flippedCards;
      card1.classList.remove("fliped");
      card2.classList.remove("fliped");
      flippedCards = [];
    }

    // Flip the clicked card and add it to the flippedCards array
    card.classList.add("fliped");
    flippedCards.push(card);

    // After flipping the card, check if there are the same two cards flipped
    if (flippedCards.length === 2) {
      const [card1, card2] = flippedCards;
      if (card1.dataset.animalId === card2.dataset.animalId) {
        // If they match, block them and increment the score
        card1.classList.add("blocked");
        card2.classList.add("blocked");
        score++;
        syncScore();
        flippedCards = [];
      }
    }
    checkGameEnd();
  }

  function flipAllCards() {
    cards.forEach(card => card.classList.add('fliped'));
  }

  function unflipAllCards() {
    cards.forEach(card => card.classList.remove('fliped'));
  }

  const cards = document.querySelectorAll(".flip-card-inner");



  flipAllCards();

  if (cards) {
    cards.forEach((card) => {
      card.addEventListener("click", () => {
        flipCard(card);

      });
    });
  }

  setTimeout(() => {
    unflipAllCards();
    timerInterval = setInterval(() => {
      time++;
      syncTime();
    }, 1000);
  }, 1500);

  syncScore();
});
