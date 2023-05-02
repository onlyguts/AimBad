<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link href="../css/score.css" rel="stylesheet">
  <link href="../css/user.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="../css/logo.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../asset/img/logo.png">
  <title>Aimbad - Leaderboard</title>
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


    $query = "SELECT COUNT(*) AS position FROM user WHERE score > (SELECT score FROM user WHERE username = '$username')";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $position = $row['position'] + 1;

    $url_query = mysqli_query($conn, "SELECT url FROM user WHERE username = '$username'");
    $url_result = mysqli_fetch_assoc($url_query);
    $url_img = isset($url_result["url"]) ? $url_result["url"] : "../asset/img/user.png";

    $points_query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $points_result = mysqli_fetch_assoc($points_query);
    $points = isset($points_result["Score"]) ? $points_result["Score"] : "0";
    $pointsfinal = isset($points_result["Score_final"]) ? $points_result["Score_final"] : "0";
    mysqli_close($conn); // Fermeture de la connexion à la base de données
?>

<div class="profil">
  <h2>My Rank</h2>
  <img src="<?php echo $url_img ?>" alt="Profile picture" class="player-photo">
  <h2><?php echo $username; ?></h2>
  <h3><span class="underline">Best Score:</span> <?php echo $points; ?></h3>
  <h3><span class="underline">Total Score:</span> <?php echo $pointsfinal; ?></h3>
  <h3><span class="underline">Rank:</span> <?php echo $position; ?></h3>
</div>

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
    </div>
    <table>
      <thead>
        <tr >
          <th >Position</th>
          <th >Username</th>
          <th >Best Score</th>
          <th >Total Score</th>
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
$num_pages_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
$num_pages = ceil(mysqli_fetch_assoc($num_pages_query)['count'] / $results_per_page); // Nombre total de pages

// Récupération de la page actuelle
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calcul de l'offset pour la requête SQL
$offset = ($current_page - 1) * $results_per_page;

// Récupération des user pour la page actuelle
$sql = "SELECT Id, username, score, admin, score_final, url FROM user ORDER BY score DESC LIMIT $offset, $results_per_page";
$result = mysqli_query($conn, $sql);

// Affichage du tableau des user
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
  
  // Ajout de [ADMIN] en rouge si l'utilisateur est un admin
  $isAdmin = $row["admin"] == 1;
  $displayName = $isAdmin ? "<span class='admin'>[ADMIN] </span>" . $username : $username;
  
  echo "<tr><td><div class='position $class'>$position</div></td><td><img src='".$row["url"]."' class='profile-pic'>$displayName</td><td>".$row["score"]."</td><td>".$row["score_final"]."</td></tr>";
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