const logoutButton = document.getElementById("logout-button");

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