<?php
// Connexion à la base de données
$servname = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'aimbad';
$conn = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);

// Vérification de l'ID de l'utilisateur à supprimer
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Suppression de l'utilisateur
    $stmt = $conn->prepare("DELETE FROM user WHERE Id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Envoi de la réponse JSON
    echo json_encode(array('success' => true));
} else {
    // Envoi de la réponse JSON en cas d'erreur
    echo json_encode(array('success' => false, 'message' => 'User ID not provided'));
}
?>
