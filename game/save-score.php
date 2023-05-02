<?php
// Vérification que le $_POST['username'] est attribué
if(isset($_POST['username']) && $_POST['username'] !== '') {
  // Récupération des données de la requête POST
  $username = $_POST['username'];
  $score = $_POST['score'];

  // Connexion à la base de données
  $servername = "localhost";
  $username_db = "root";
  $password_db = "root";
  $dbname = "aimbad";

  $conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Vérification si l'utilisateur existe déjà
  $sql_check_user = "SELECT * FROM user WHERE Username='$username'";
  $result = mysqli_query($conn, $sql_check_user);

  if (mysqli_num_rows($result) > 0) {
    // Récupération de l'ancien score
    $row = mysqli_fetch_assoc($result);
    $old_score = $row['score'];
    $id = $row['Id'];
    
    // Mise à jour du score pour l'utilisateur existant si le nouveau score est plus grand
    if ($score > $old_score) {
      $sql_update = "UPDATE user SET score='$score' WHERE Id='$id'";
      if (mysqli_query($conn, $sql_update)) {
        echo "Score updated successfully";
      } else {
        echo "Error updating score: " . mysqli_error($conn);
      }
    } else {
      echo "Score not updated";
    }

      $sql_update = "UPDATE user SET Score_final=Score_final + $score WHERE Id='$id'";
      if (mysqli_query($conn, $sql_update)) {
        echo "Score updated successfully";
      } else {
        echo "Error updating score: " . mysqli_error($conn);
      }

  }

  // Fermeture de la connexion à la base de données
  mysqli_close($conn);
} else {
  // Si le $_POST['username'] n'est pas attribué, on renvoie une erreur
  echo "Error saving score - Username not specified";
}
?>
