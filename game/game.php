<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="game.css" rel="stylesheet" >
    <link href="../css/logo.css" rel="stylesheet" >
    <link href="../css/user.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Aimbad - In Game</title>
  </head>
  <body>
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
            echo "<img src=\"../asset/img/user.png\" alt=\"Logo\" id=\"logo2\">";
          }
        } else {
          echo "<img src=\"../asset/img/user.png\" alt=\"Logo\" id=\"logo2\">";
        }
        ?>
        <h5><?php if (isset($_SESSION['username'])) { echo 'Welcome, ' . $_SESSION['username']; } ?></h5>
        <h5><?php if (!isset($_SESSION['username'])) { echo 'Welcome, Guest'; } ?></h5>
      </div>
      <div id="logout-button2">
        <button id="logout-button" <?php if (!isset($_SESSION['username'])) { echo 'style="display:none;"'; } ?>>Déconnexion</button>
      </div>
    <div class="logo-container">
      <a href="../index.php" class="lien-icone">
        <img src="../asset/img/logo.png" alt="" class="logo">
        <h1>AimBad</h1>
      </a>
    </div>
    <div class="container">
      <div id="score-container">
        Score: <span id="score">0</span><br>
        Temps: <span id="timer">10:000</span><br>
        <button id="menu-retry">Rejouer</button><br>
      </div>
    </div>

    <div id="cercles-container">
      <!-- Le reste du contenu de la page -->
    </div>
    <p id="game-over-message" class="hidden">END</p>
    <script src="app.js"></script>
    <script src="script.js"></script>
  </body>
</html>