
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
<html>

<head>
    <title>Titre de la page</title>
    <meta charset="UTF-8">
    <link href="admin_table.css" rel="stylesheet">
</head>

<body>
<div>
    <table class="leaderboard-menu">
        <tr>
            <th class="top">Id</th>
            <th class="top">Username</th>
            <th class="top">Email</th>
            <th class="top">Best Score</th>
            <th class="top">Total Score</th>
            <th class="top">Actions</th>
        </tr>
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
    </table>
</div>
<script src="admin.js"></script>
</body>


</html>