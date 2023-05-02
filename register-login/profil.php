<?php
session_start();
$usernameChanged = false;
$urlChanged = false;
require_once('../config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
  // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
  header("Location: login.php");
  exit();
}

// Récupération des informations de l'utilisateur connecté à partir de la base de données


$conn = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$stmt = $conn->prepare("SELECT * FROM user WHERE Username = :username");
$stmt->execute(['username' => $_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire de changement de nom d'utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Vérifie si le nouveau nom d'utilisateur a été soumis
  if (isset($_POST['new-username']) && !empty($_POST['new-username'])) {
    // Vérifie si le nouveau nom d'utilisateur a une longueur suffisante
    if (strlen($_POST['new-username']) < 3) {
      echo "<h5>Le nom d'utilisateur doit être d'au moins 3 caractères.</h5>";
    } else {
      // Vérifie si le nouveau nom d'utilisateur n'est pas déjà pris
      $newUsername = $_POST['new-username'];
      $stmt = $conn->prepare("SELECT * FROM user WHERE Username = :username");
      $stmt->execute(['username' => $newUsername]);
      $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($existingUser) {
        echo "<h5>Ce nom d'utilisateur est déjà pris.</h5>";
      } else {
        // Met à jour le nom d'utilisateur dans la base de données
        $stmt = $conn->prepare("UPDATE user SET Username = :newUsername WHERE Id = :id");
        $stmt->execute(['newUsername' => $newUsername, 'id' => $user['Id']]);
        // Met à jour la variable de session avec le nouveau nom d'utilisateur
        $_SESSION['username'] = $newUsername;
        // Redirige vers la page de profil mise à jour
        header("Location: profil.php");
        $usernameChanged = true;
        exit();
      }
    }
  }

  // Traitement du formulaire de changement d'URL de l'utilisateur
  if (isset($_POST['new-url']) && !empty($_POST['new-url'])) {
    $newUrl = $_POST['new-url'];
    // Met à jour l'URL de l'utilisateur dans la base de données
    $stmt = $conn->prepare("UPDATE user SET Url = :newUrl WHERE Id = :id");
    $stmt->execute(['newUrl' => $newUrl, 'id' => $user['Id']]);
    // Redirige vers la page de profil mise à jour
    header("Location: profil.php");
    $urlChanged = true;
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil de <?php echo $user['Username']; ?></title>
  <link rel="stylesheet" href="../css/profil.css">
  <link rel="stylesheet" href="../css/user.css">
  <link rel="stylesheet" href="../css/logo.css">
  <link rel="icon" type="image/png" href="../asset/img/logo.png">
</head>
<body>
<div id="logo-container2">
        <?php
   
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
  </div id="menu-profil">
  <div id="change-username">
  <h2>Changer de nom d'utilisateur</h2>
  <form action="" method="POST">
    <label for="new-username">Nouveau nom d'utilisateur :</label>
    <input type="text" id="new-username" name="new-username">
    <button type="submit">Changer de nom d'utilisateur</button>
  </form>
  </div>

  <div id="change-url">
  <h2>Changer l'URL</h2>
  <form action="" method="POST">
    <label for="new-url">Nouvelle URL :</label>
    <input type="text" id="new-url" name="new-url">
    <button type="submit">Changer l'URL</button>
  </form>
</div>
</div>
<script src="deconnexion.js"></script>
</body>
</html>

