<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $servname = 'localhost';
    $user = 'root';
    $pass = 'root';
    $dbname = 'aimbad';

    if (isset($_FILES['profile-picture'])) {
      $file_name = $_FILES['profile-picture']['name'];
      $file_tmp = $_FILES['profile-picture']['tmp_name'];
      $file_size = $_FILES['profile-picture']['size'];
      $file_type = $_FILES['profile-picture']['type'];
      $file_ext = strtolower(end(explode('.', $file_name)));
      $extensions = array("jpeg", "jpg", "png");
    
      if (in_array($file_ext, $extensions) === false) {
        $error = "extension not allowed, please choose a JPEG, JPG, or PNG file.";
      }
    
      if ($file_size > 2097152) {
        $error = 'File size must be exactly 2 MB';
      }
    
      if (empty($error) == true) {
        move_uploaded_file($file_tmp, "../uploads/" . $file_name);
        // save the filename in the database or wherever you need it
      }
    }

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
    $url = $_POST['url'];

    // Échapper les caractères spéciaux pour éviter les injections SQL
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $url = mysqli_real_escape_string($conn, $url);


    // Vérifier si l'utilisateur existe déjà dans la base de données
    $sql = "SELECT * FROM user WHERE Username='$username'";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM user WHERE Email='$email'";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result) == 0) {
        if (mysqli_num_rows($result2) == 0) {
            // Si l'utilisateur n'existe pas encore, ajouter ses identifiants à la base de données
            $sql = "INSERT INTO user (Username, Email, Password, Url) VALUES ('$username', '$email', '$password', '$url')";
            $result = mysqli_query($conn, $sql);
    
            // Rediriger vers la page de connexion
            header('Location: ../index.php');
            session_start();
            $_SESSION['username'] = $username;
           
            exit();
        } else {
            // Si l'utilisateur existe déjà, afficher un message d'erreur
            $error = 'Email already taken';
        }
    } else {
        // Si l'utilisateur existe déjà, afficher un message d'erreur
        $error = 'Username already taken';
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

  <title>Register</title>
</head>
<body>
  <h1>Register</h1>
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
