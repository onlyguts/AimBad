<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servname = 'localhost';
    $user = 'root';
    $pass = 'root';
    $dbname = 'aimbad';
    // Créer une connexion à la base de données
    $conn = mysqli_connect($servname, $user, $pass, $dbname);
    // Vérifier la connexion
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    // Récupérer les identifiants de l'utilisateur
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $url = isset($_POST['url']) ? $_POST['url'] : "https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png";

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Échapper les caractères spéciaux pour éviter les injections SQL
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password_hashed = mysqli_real_escape_string($conn, $password_hashed);
    $url = mysqli_real_escape_string($conn, $url);

    if ($url === '') {
      $url = "https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png";
    }

    // Vérifier si l'utilisateur existe déjà dans la base de données
    $sql = "SELECT * FROM user WHERE Username='$username'";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM user WHERE Email='$email'";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result) == 0) {
        if (mysqli_num_rows($result2) == 0) {
          if (strlen($_POST['username']) < 3) {
           
            $error = "Le nom d'utilisateur doit être d'au moins 3 caractères.";
          } else {
            // Si l'utilisateur n'existe pas encore, ajouter ses identifiants à la base de données
            $sql = "INSERT INTO user (Username, Email, Password, Url) VALUES ('$username', '$email', '$password_hashed', '$url')";
            $result = mysqli_query($conn, $sql);
    
            // Rediriger vers la page de connexion
            header('Location: ../index.php');
            session_start();
            $_SESSION['username'] = $username;
            exit();
          }
        } else {
            // Si l'utilisateur existe déjà, afficher un message d'erreur
            $error = 'Email already taken!';
        }
    } else {
        // Si l'utilisateur existe déjà, afficher un message d'erreur
        $error = 'Username already taken!';
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="login.css">
  <link href="../css/logo.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../asset/img/logo.png">
  <title>Register</title>
</head>
<body>
<div class="logo-container">
    <a href="../index.php" class="lien-icone">
      <img src="../asset/img/logo.png" alt="" class="logo">
      <h1>AimBad</h1>
    </a>
  </div>
 
  <?php if (isset($error)): ?>
    <p><?= $error ?></p>
  <?php endif ?>
  <form method="post" action="register.php">

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="url">Profil Picture URL:</label>
    <input type="url" id="url" name="url">
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Register</button>
    <a href="login.php">Login Now !</a>
  </form>
</body>
</html>
