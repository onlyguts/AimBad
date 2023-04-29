<<<<<<< Updated upstream
const cerclesContainer = document.getElementById("cercles-container");
const scoreElement = document.getElementById("score");
const timerElement = document.getElementById("timer");
const timerElement2 = document.getElementById("temps-restant");
const gameOverMessage = document.getElementById("game-over-message");
const logoContainer = document.getElementById("logo-container2");
const logoImg = logoContainer.querySelector("img");
const logoutButton = document.getElementById("logout-button");
const logoutButton1 = document.getElementById("logout-button-1");


let score = 0;
let timerInterval, timeLeft;
let username = "";
const xhr = new XMLHttpRequest();

// Ouvrir une requête GET vers un fichier PHP qui renvoie le nom d'utilisateur
xhr.open('GET', 'name.php', true);

// Envoyer la requête
xhr.send();

// Traiter la réponse de la requête
xhr.onreadystatechange = function() {
  if (xhr.readyState === 4 && xhr.status === 200) {
      const usernames = xhr.responseText;
      const userList = usernames.split(","); // Si la réponse est une liste séparée par des virgules
      username = userList[0]; // Affecter le premier nom d'utilisateur à la variable
  }
};


function ajouterCercle() {
  const cercle = document.createElement("div");
  cercle.classList.add("cercle");

  const x = Math.floor(Math.random() * (cerclesContainer.clientWidth - cercle.clientWidth - 70)) + 10;
  const y = Math.floor(Math.random() * (cerclesContainer.clientHeight - cercle.clientHeight - 70)) + 10;
  cercle.style.left = `${x}px`;
  cercle.style.top = `${y}px`;
  cerclesContainer.appendChild(cercle);
  cercle.addEventListener("click", () => {
    supprimerCercle(cercle);
    if (!timerInterval) {
      demarrerTimer();
      console.log(username)
    }
  });
}

function supprimerCercle(cercle) {
  cercle.style.transition = "opacity 0.5s"; // ajouter une transition de 0.5s pour l'opacité
  cercle.style.opacity = "0"; // rendre le cercle transparent
  setTimeout(() => {
    cercle.remove();
  }, 1000); // attendre 0.5s avant de supprimer définitivement le cercle
  score += 1;
  scoreElement.textContent = score;
  ajouterCercle();
}


function demarrerTimer() {
  timeLeft = 10;
  startTime = new Date();
  mettreAJourTemps();
  timerInterval = setInterval(mettreAJourTemps, 10);
}

function arreterTimer() {
  clearInterval(timerInterval);
  timerInterval = null;
}

function reinitialiserTimer() {
  arreterTimer();
  timeLeft = 10;
  timerElement.textContent = `10:000`;
}

function mettreAJourTemps() {
  endTime = new Date();
  const tempsEcoule = (endTime - startTime); 
  const minutes = Math.floor(tempsEcoule / 60000);
  const secondesRestantes = Math.max(Math.floor((timeLeft * 1000 - tempsEcoule) / 1000), 0).toString().padStart(2, "0");
  const millisecondesRestantes = Math.max((timeLeft * 1000 - tempsEcoule) % 1000, 0).toString().padStart(3, "0");
  timerElement.textContent = `${secondesRestantes}:${millisecondesRestantes}`; 
  if (tempsEcoule >= timeLeft * 1000) {
    clearInterval(timerInterval); 
    gameOverMessage.classList.remove("hidden");
    cerclesContainer.innerHTML = "";
    fetch('save-score.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `username=${username}&score=${score}`
    })
    .then(response => response.text())
    .then(result => {
      console.log(result); // Afficher la réponse du serveur
    })
    .catch(error => {
      console.error(error); // Afficher les erreurs éventuelles
    });
  }
}

document.getElementById("menu-retry").addEventListener("click", function () {
  reinitialiserJeu();
});

function reinitialiserJeu() {
  score = 0
  cerclesContainer.innerHTML = ""; // Supprimer tous les cercles
  arreterTimer(); // Arrêter le compteur de temps
  scoreElement.textContent = score;
  reinitialiserTimer(); // Mettre à jour l'affichage du temps
  gameOverMessage.classList.add("hidden");
  ajouterCercle();
}

ajouterCercle();


const tableBody = document.querySelector("tbody");
const paginationContainer = document.querySelector(".pagination");

// Récupération des scores depuis l'API
fetch("http://localhost:0080/api/score")
  .then(response => response.json())
  .then(scores => {
    // Tri des scores du plus grand au plus petit
    scores.sort((a, b) => b.score - a.score);

    // Génération des lignes de tableau pour chaque score
    let position = 1;
    for (let score of scores) {
      const tr = document.createElement("tr");
      const tdPosition = document.createElement("td");
      const tdUsername = document.createElement("td");
      const tdScore = document.createElement("td");

      tdPosition.textContent = position;
      tdUsername.textContent = score.username;
      tdScore.textContent = score.score;

      tr.appendChild(tdPosition);
      tr.appendChild(tdUsername);
      tr.appendChild(tdScore);

      tableBody.appendChild(tr);

      position++;
    }

    // Récupération de la pagination
    const paginationLinks = paginationContainer.querySelectorAll("a");

    // Ajout de l'écouteur d'événement sur chaque lien de pagination
    paginationLinks.forEach(link => {
      link.addEventListener("click", event => {
        event.preventDefault();
        const page = link.dataset.page;

        // Suppression des lignes de tableau existantes
        tableBody.innerHTML = "";

        // Récupération des scores pour la page sélectionnée
        fetch(`http://localhost:0080/api/score?page=${page}`)
          .then(response => response.json())
          .then(scores => {
            // Tri des scores du plus grand au plus petit
            scores.sort((a, b) => b.score - a.score);

            // Génération des lignes de tableau pour chaque score
            let position = (page - 1) * 10 + 1;
            for (let score of scores) {
              const tr = document.createElement("tr");
              const tdPosition = document.createElement("td");
              const tdUsername = document.createElement("td");
              const tdScore = document.createElement("td");

              tdPosition.textContent = position;
              tdUsername.textContent = score.username;
              tdScore.textContent = score.score;

              tr.appendChild(tdPosition);
              tr.appendChild(tdUsername);
              tr.appendChild(tdScore);

              tableBody.appendChild(tr);

              position++;
            }
          })
          .catch(error => console.error(error));
      });
    });
  })
  .catch(error => console.error(error));
  

  logoImg.addEventListener("click", () => {
    window.location.href = "../register-login/login.php"; // Rediriger vers la page d'accueil
  });
  
  logoutButton.addEventListener("click", () => {
    fetch("../logout.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "../index.php";
        } else {
          console.log(data.message);
        }
      })
      .catch(error => console.error(error));
  });
  
  logoutButton1.addEventListener("click", () => {
    fetch("../logout.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "../index.php";
        } else {
          console.log(data.message);
        }
      })
      .catch(error => console.error(error));
=======
const cerclesContainer = document.getElementById("cercles-container");
const scoreElement = document.getElementById("score");
const timerElement = document.getElementById("timer");
const timerElement2 = document.getElementById("temps-restant");
const gameOverMessage = document.getElementById("game-over-message");
const logoContainer = document.getElementById("logo-container2");
const logoImg = logoContainer.querySelector("img");
const logoutButton = document.getElementById("logout-button");
const logoutButton1 = document.getElementById("logout-button-1");


let score = 0;
let timerInterval, timeLeft;
let username = "";
const xhr = new XMLHttpRequest();

// Ouvrir une requête GET vers un fichier PHP qui renvoie le nom d'utilisateur
xhr.open('GET', 'name.php', true);

// Envoyer la requête
xhr.send();

// Traiter la réponse de la requête
xhr.onreadystatechange = function() {
  if (xhr.readyState === 4 && xhr.status === 200) {
      const usernames = xhr.responseText;
      const userList = usernames.split(","); // Si la réponse est une liste séparée par des virgules
      username = userList[0]; // Affecter le premier nom d'utilisateur à la variable
  }
};


function ajouterCercle() {
  const cercle = document.createElement("div");
  cercle.classList.add("cercle");

  const x = Math.floor(Math.random() * (cerclesContainer.clientWidth - cercle.clientWidth - 70)) + 10;
  const y = Math.floor(Math.random() * (cerclesContainer.clientHeight - cercle.clientHeight - 70)) + 10;
  cercle.style.left = `${x}px`;
  cercle.style.top = `${y}px`;
  cerclesContainer.appendChild(cercle);
  cercle.addEventListener("click", () => {
    supprimerCercle(cercle);
    if (!timerInterval) {
      demarrerTimer();
      console.log(username)
    }
  });
}

function supprimerCercle(cercle) {
  cercle.style.transition = "opacity 0.5s"; // ajouter une transition de 0.5s pour l'opacité
  cercle.style.opacity = "0"; // rendre le cercle transparent
  setTimeout(() => {
    cercle.remove();
  }, 1000); // attendre 0.5s avant de supprimer définitivement le cercle
  score += 1;
  scoreElement.textContent = score;
  ajouterCercle();
}


function demarrerTimer() {
  timeLeft = 10;
  startTime = new Date();
  mettreAJourTemps();
  timerInterval = setInterval(mettreAJourTemps, 10);
}

function arreterTimer() {
  clearInterval(timerInterval);
  timerInterval = null;
}

function reinitialiserTimer() {
  arreterTimer();
  timeLeft = 10;
  timerElement.textContent = `10:000`;
}

function mettreAJourTemps() {
  endTime = new Date();
  const tempsEcoule = (endTime - startTime); 
  const minutes = Math.floor(tempsEcoule / 60000);
  const secondesRestantes = Math.max(Math.floor((timeLeft * 1000 - tempsEcoule) / 1000), 0).toString().padStart(2, "0");
  const millisecondesRestantes = Math.max((timeLeft * 1000 - tempsEcoule) % 1000, 0).toString().padStart(3, "0");
  timerElement.textContent = `${secondesRestantes}:${millisecondesRestantes}`; 
  if (tempsEcoule >= timeLeft * 1000) {
    clearInterval(timerInterval); 
    gameOverMessage.classList.remove("hidden");
    cerclesContainer.innerHTML = "";
    fetch('save-score.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `username=${username}&score=${score}`
    })
    .then(response => response.text())
    .then(result => {
      console.log(result); // Afficher la réponse du serveur
    })
    .catch(error => {
      console.error(error); // Afficher les erreurs éventuelles
    });
  }
}

document.getElementById("menu-retry").addEventListener("click", function () {
  reinitialiserJeu();
});

function reinitialiserJeu() {
  score = 0
  cerclesContainer.innerHTML = ""; // Supprimer tous les cercles
  arreterTimer(); // Arrêter le compteur de temps
  scoreElement.textContent = score;
  reinitialiserTimer(); // Mettre à jour l'affichage du temps
  gameOverMessage.classList.add("hidden");
  ajouterCercle();
}

ajouterCercle();


const tableBody = document.querySelector("tbody");
const paginationContainer = document.querySelector(".pagination");

// Récupération des scores depuis l'API
fetch("http://localhost:0080/api/score")
  .then(response => response.json())
  .then(scores => {
    // Tri des scores du plus grand au plus petit
    scores.sort((a, b) => b.score - a.score);

    // Génération des lignes de tableau pour chaque score
    let position = 1;
    for (let score of scores) {
      const tr = document.createElement("tr");
      const tdPosition = document.createElement("td");
      const tdUsername = document.createElement("td");
      const tdScore = document.createElement("td");

      tdPosition.textContent = position;
      tdUsername.textContent = score.username;
      tdScore.textContent = score.score;

      tr.appendChild(tdPosition);
      tr.appendChild(tdUsername);
      tr.appendChild(tdScore);

      tableBody.appendChild(tr);

      position++;
    }

    // Récupération de la pagination
    const paginationLinks = paginationContainer.querySelectorAll("a");

    // Ajout de l'écouteur d'événement sur chaque lien de pagination
    paginationLinks.forEach(link => {
      link.addEventListener("click", event => {
        event.preventDefault();
        const page = link.dataset.page;

        // Suppression des lignes de tableau existantes
        tableBody.innerHTML = "";

        // Récupération des scores pour la page sélectionnée
        fetch(`http://localhost:0080/api/score?page=${page}`)
          .then(response => response.json())
          .then(scores => {
            // Tri des scores du plus grand au plus petit
            scores.sort((a, b) => b.score - a.score);

            // Génération des lignes de tableau pour chaque score
            let position = (page - 1) * 10 + 1;
            for (let score of scores) {
              const tr = document.createElement("tr");
              const tdPosition = document.createElement("td");
              const tdUsername = document.createElement("td");
              const tdScore = document.createElement("td");

              tdPosition.textContent = position;
              tdUsername.textContent = score.username;
              tdScore.textContent = score.score;

              tr.appendChild(tdPosition);
              tr.appendChild(tdUsername);
              tr.appendChild(tdScore);

              tableBody.appendChild(tr);

              position++;
            }
          })
          .catch(error => console.error(error));
      });
    });
  })
  .catch(error => console.error(error));
  

  logoImg.addEventListener("click", () => {
    window.location.href = "../register-login/login.php"; // Rediriger vers la page d'accueil
  });
  
  logoutButton.addEventListener("click", () => {
    fetch("../logout.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "../index.php";
        } else {
          console.log(data.message);
        }
      })
      .catch(error => console.error(error));
  });
  
  logoutButton1.addEventListener("click", () => {
    fetch("../logout.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "../index.php";
        } else {
          console.log(data.message);
        }
      })
      .catch(error => console.error(error));
>>>>>>> Stashed changes
});