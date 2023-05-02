<?php
session_start();
// Connexion à la base de données
require_once('../config.php');
$conn = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);

// Vérifier si l'utilisateur est un administrateur
$stmt = $conn->prepare("SELECT admin FROM user WHERE Username=:username");
$stmt->execute(array(':username' => $_SESSION['username']));

$admin = $stmt->fetchColumn();

if ($admin == 0) {
    // Rediriger vers la page principale si l'utilisateur n'est pas un administrateur
    header('Location: ../index.php');
    consol.logs($_SESSION['username']);
    exit();
}

// Si une recherche a été effectuée, récupérer les résultats
if(isset($_GET['search']) && !empty($_GET['search'])) {
  $search = $_GET['search'];
  $stmt = $conn->prepare("SELECT * FROM user WHERE Username LIKE :search");
  $stmt->execute(array(':search' => "%$search%"));
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // Sinon, récupérer la liste complète des utilisateurs
  $stmt = $conn->prepare("SELECT * FROM user");
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../css/logo.css">
    <link rel="stylesheet" href="../css/user.css">
</head>

<body>

    <div class="wrapper">
        <div id="logo-container2">
            <?php

require_once('../config.php');

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
            <button id="logout-button"
                <?php if (!isset($_SESSION['username'])) { echo 'style="display:none;"'; } ?>>Déconnexion</button>
        </div>
        <div class="logo-container">
            <a href="../index.php" class="lien-icone">
                <img src="../asset/img/logo.png" alt="" class="logo">
                <h1>AimBad</h1>
            </a>
        </div>
        <div class="panel-top">
        <h1 class="simple-title">Panel Admin</h1>
        <form method="get">
            
            <label for="search"></label>
            <input type="text" id="search" name="search" placeholder="Nom d'utilisateur"
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                
            <button type="submit">Rechercher</button>
        </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Best Score</th>
                    <th>Total Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['Id']; ?></td>
                    <td><?php echo $user['Username']; ?></td>
                    <td><?php echo $user['Email']; ?></td>
                    <td><?php echo $user['Score']; ?></td>
                    <td><?php echo $user['Score_final']; ?></td>
                    <td><button class="delete-button" data-id="<?php echo $user['Id']; ?>">&times;</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="admin.js"></script>
</body>

</html>