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
    $password = $_POST['password'];

    // Échapper les caractères spéciaux pour éviter les injections SQL
    $username = mysqli_real_escape_string($conn, $username);

    // Crypter le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier les identifiants dans la base de données
    $sql = "SELECT * FROM user WHERE Username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Vérifier le mot de passe crypté
        if (password_verify($password, $user['Password'])) {

            // Si les identifiants sont corrects, rediriger vers la page d'accueil
            header('Location: ..\index.php');
            session_start();
            $_SESSION['username'] = $username;

            exit();
        }
    }

    // Si les identifiants sont incorrects, afficher un message d'erreur
    $error = 'Invalid username or password';

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
  <title>Login</title>
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
  <form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
    <a href="register.php">Register Now !</a>
  </form>
</body>
</html>
