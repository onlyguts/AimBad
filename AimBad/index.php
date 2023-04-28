<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Aimbad</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/user.css" rel="stylesheet">
   <!-- J VIENS D ADD UN COMMENTAIRE -->
  </head>
  <body>
    <div class="menu">
      <div id="logo-container2">
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
          $username = $_SESSION['username'];

          // Connexion à la base de données
          $servname = 'localhost';
          $user = 'root';
          $pass = 'root';
          $dbname = 'aimbad';

          $conn = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);

          // Récupération de l'URL de l'image de profil
          $stmt = $conn->prepare("SELECT Url FROM user WHERE Username = :username");
          $stmt->execute(['username' => $username]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($result) {
            $url = $result['Url'];
            echo "<img src=\"$url\" alt=\"Logo\" id=\"user-info\">";
          } else {
            echo "<img src=\"asset/img/user.png\" alt=\"Logo\" id=\"logo2\">";
          }
        } else {
          echo "<img src=\"asset/img/user.png\" alt=\"Logo\" id=\"logo2\">";
        }
        ?>
        <h5><?php if (isset($_SESSION['username'])) { echo 'Welcome, ' . $_SESSION['username']; } ?></h5>
        <h5><?php if (!isset($_SESSION['username'])) { echo 'Welcome, Guest'; } ?></h5>
      </div>
      <div id="logout-button2">
        <button id="logout-button" <?php if (!isset($_SESSION['username'])) { echo 'style="display:none;"'; } ?>>Déconnexion</button>
      </div>
      <div id="logo-container">
        <div class="logo-circle">
          <img src="asset/img/logo.png" alt="" class="logo">
          <h1>AimBad</h1>
        </div>
      </div>
      <ul class="menu-game">
        <li><a href="game/game.php">PLAY</a></li>
        <li><a href="game/score.php">RANK</a></li>
      </ul>
    </div>
    <script src="script.js"></script>
  </body>
  <footer id="footer">
  <div class="footer-links">
    <a href="#">Contact us</a>
    <a href="#">Terms and conditions</a>
    <a href="#">Privacy policy</a>
  </div>
  <div class="footer-right">
    <p>All rights reserved © 2023 Aimbad</p>
  </div>
</footer>
</html>
