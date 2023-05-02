const logoContainer = document.getElementById("logo-container2");
const logoImg = logoContainer.querySelector("img");
const logoutButton = document.getElementById("logout-button-1");

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