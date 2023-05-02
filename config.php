<?php
$servname = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'aimbad';

$conn = mysqli_connect($servname, $user, $pass, $dbname);

if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}
?>