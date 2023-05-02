<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Aimbad</title>
    <link rel="icon" type="image/png" href="asset/img/logo.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/user.css" rel="stylesheet">

   
  </head>
  <body>
    <div class="menu">
      <div id="logo-container2">
      <?php
session_start();
require_once('config.php');

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  // Connexion à la base de données
  $conn = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);

  // Récupération de l'URL de l'image de profil
  $stmt = $conn->prepare("SELECT * FROM user WHERE Username = :username");
  $stmt->execute(['username' => $username]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $url = $result['Url'];
    echo "<a href=\"register-login/profil.php\"><img src=\"$url\" alt=\"Logo\" id=\"user-info\"></a>";
  } else {
    echo "<a href=\"register-login/profil.php\"><img src=\"asset/img/user.png\" alt=\"Logo\" id=\"logo2\"></a>";
  }
} else {
  echo "<a href=\"register-login/login.php\"><img src=\"asset/img/user.png\" alt=\"Logo\" id=\"logo2\"></a>";
}
?>


<h5>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT admin FROM user WHERE Username=:username");
        $stmt->execute(array(':username' => $username));
        $admin = $stmt->fetchColumn();
        if ($admin == 1) {
            echo '<span style="color: red">[ADMIN]</span> ';
        }
        echo $username;
    } else {
        echo 'Welcome, Guest';
    }
    ?>
</h5>

      </div>
      <div id="logout-button2">
        <button id="logout-button" <?php if (!isset($_SESSION['username'])) { echo 'style="display:none;"'; } ?>>Déconnexion</button>
      </div>
      <div id="admin-button">
  <a href="admin/admin.php">
    <?php if (isset($result) && $result['admin'] == 1) {echo '<button id="admin-btn">Actions d\'administrateur</button>';}?>
  </a>
</div>

      <div id="logo-container">
        <div class="logo-circle">
          <img src="asset/img/logo.png" alt="" class="logo">
          <h1>AimBad</h1>
        </div>
      </div>
      <div class="player-connect">
      <?php
      $num_connected_users = count($_SESSION) > 0 ? count($_SESSION) : 0;
      echo "<h4>Nombre de joueurs connectés : " . $num_connected_users . "<h4/>";
      ?>
      </div>
      <ul class="menu-game">
        <li><a href="game/game.php">PLAY</a></li>
        <li><a href="game/score.php">LEADERBOARD</a></li>
      </ul>
   </div>
    <script src="script.js"></script>
  </body>
  <footer id="footer">
  <div class="footer-links">
    <a href="#">Contact us</a>
    <a>·</a>
    <a href="#">Terms and conditions</a>
    <a>·</a>
    <a href="#">Privacy policy</a>
  </div>
  <div class="footer-right">
    <p>All rights reserved © 2023 Aimbad</p>
  </div>
</footer>
</html>
