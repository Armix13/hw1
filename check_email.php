<?php

require_once './dbconfig.php';
header('Content-Type: application/json');

if (!isset($_GET['q'])) {
    echo json_encode(['exists' => false]);
    exit();
}

$connessione = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]);
if(!$connessione){
    die(mysqli_connect_error());
}

$email = $_GET['q'];
$email = mysqli_real_escape_string($connessione, $email);


$query = "SELECT email FROM USERS WHERE email = '$email'";
$res = mysqli_query($connessione, $query) or die(mysqli_error($connessione));

if(mysqli_num_rows($res) > 0){
    echo json_encode(['exists' => true]);
}else {
    echo json_encode(['exists' => false]);
}

mysqli_close($connessione);

?>
