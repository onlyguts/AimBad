<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="game.css" rel="stylesheet" >
    <link href="../css/logo.css" rel="stylesheet" >
    <link href="../css/user.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../asset/img/logo.png">
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
            echo "<a href=\"../register-login/profil.php\"><img src=\"$url\" alt=\"Logo\" id=\"user-info\"></a>";
          } else {
            echo "<a href=\"../register-login/profil.php\"><img src=\"../asset/img/user.png\" alt=\"Logo\" id=\"logo2\"></a>";
          }
        } else {
          echo "<a href=\"../register-login/login.php\"><img src=\"../asset/img/user.png\" alt=\"Logo\" id=\"logo2\"></a>";
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
    <div class="logo-container">
      <a href="../index.php" class="lien-icone">
        <img src="../asset/img/logo.png" alt="" class="logo">
        <h1>AimBad</h1>
      </a>
    </div>
    <div class="container">
      <div id="score-container">
        Score: <span id="score">0</span><br>
        Temps: <span id="timer">25:000</span><br>
        <button id="menu-retry">Rejouer</button><br>
      </div>
    </div>

    <div id="cercles-container"></div>
    <div id="background-buttons-container">
    <button id="background-button-3" class="background-button" onclick="changeBackground('')">Basic</button>
  <button id="background-button-1" class="background-button" onclick="changeBackground('../asset/img/background-game/inferno.jpg')">Inferno</button>
  <button id="background-button-2" class="background-button" onclick="changeBackground('../asset/img/background-game/vertigo.jpg')">Vertigo</button>
</div>

    <p id="game-over-message" class="hidden">END</p>
    <script src="app.js"></script>
  </body>
</html>