<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link href="../css/score.css" rel="stylesheet">
  <link href="../css/user.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="../css/logo.css" rel="stylesheet">
  <title>Aimbad - In Game</title>
</head>


<body>
  <div class="logo-container">
    <a href="../index.php" class="lien-icone">
      <img src="../asset/img/logo.png" alt="" class="logo">
      <h1>AimBad</h1>
    </a>
  </div>

  <div class="score-container">
  <div class="player-info">
  <?php
    // Connexion à la base de données
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "root";
    $dbname = "aimbad";

    $conn = mysqli_connect($servername, $usernameDB, $passwordDB, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    session_start(); // Début de la session

    if (isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
  } else {
      $username = "Guest";
  }


    $query = "SELECT COUNT(*) AS position FROM scores WHERE score > (SELECT score FROM scores WHERE username = '$username')";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $position = $row['position'] + 1;

    $url_query = mysqli_query($conn, "SELECT url FROM user WHERE username = '$username'");
    $url_result = mysqli_fetch_assoc($url_query);
    $url_img = isset($url_result["url"]) ? $url_result["url"] : "../asset/img/user.png";

    $points_query = mysqli_query($conn, "SELECT score FROM scores WHERE username = '$username'");
    $points_result = mysqli_fetch_assoc($points_query);
    $points = isset($points_result["score"]) ? $points_result["score"] : "0";

    mysqli_close($conn); // Fermeture de la connexion à la base de données
  ?>

  <img src="<?php echo $url_img ?>" alt="Profile picture" class="player-photo">
  <h2><?php echo $username; ?></h2>
  <h3>Score: <?php echo $points; ?></h3>
  <h3>Rank: <?php echo $position; ?></h3>
</div>

</div>


  <div class="menu">
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
      <div id="logout-button-2">
        <button id="logout-button-1" <?php if (!isset($_SESSION['username'])) { echo 'style="display:none;"'; } ?>>Déconnexion</button>
      </div>
    <div class="logo-container">
    </div>
    <table>
      <thead>
        <tr>
          <th>Position</th>
          <th>Username</th>
          <th>Score</th>
        </tr>
      </thead>
      <tbody>
        <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "aimbad";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Paramètres de la pagination
$results_per_page = 10; // Nombre de résultats par page
$num_pages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM scores")) / $results_per_page); // Nombre total de pages

// Récupération de la page actuelle
if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

// Calcul de l'offset pour la requête SQL
$offset = ($current_page - 1) * $results_per_page;

// Récupération des scores pour la page actuelle
$sql = "SELECT username, score FROM scores ORDER BY score DESC LIMIT $offset, $results_per_page";
$result = mysqli_query($conn, $sql);

// Affichage du tableau des scores
$position = ($current_page - 1) * $results_per_page + 1;
echo "<table>";
echo "<tbody>";
while ($row = mysqli_fetch_assoc($result)) {
  $class = "";
  if ($position == 1) {
    $class = "one";
  } else if ($position == 2) {
    $class = "two";
  } else if ($position == 3) {
    $class = "three";
  }
  $username = $row["username"];
  $url_query = mysqli_query($conn, "SELECT url FROM user WHERE username = '$username'");
  $url_result = mysqli_fetch_assoc($url_query);
  $url = isset($url_result["url"]) ? $url_result["url"] : "../asset/img/user.png";
  
  echo "<tr><td><div class='position $class'>$position</div></td><td><img src='$url' class='profile-pic'>".$username."</td><td>".$row["score"]."</td></tr>";
  $position++;
}
echo "</tbody>";
echo "</table>";

// Affichage de la pagination
echo "<div class='pagination'>";
for ($i = 1; $i <= $num_pages; $i++) {
  if ($i == $current_page) {
    echo "<span class='current-page'>$i</span>";
  } else {
    echo "<a href='score.php?page=$i'>$i</a>";
  }
}
echo "</div>";

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>

      </tbody>
    </table>
  </div>
  <script src="connection.js"></script>
</body>

</html>