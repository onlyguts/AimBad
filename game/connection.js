const logoContainer = document.getElementById("logo-container2");
const logoImg = logoContainer.querySelector("img");
const logoutButton = document.getElementById("logout-button-1");

logoImg.addEventListener("click", () => {
  window.location.href = "../registration/login.php"; // Rediriger vers la page d'accueil
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