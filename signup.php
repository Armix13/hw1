<?php

require_once './dbconfig.php';
require_once './check_login.php';

if(checkLogin()){
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["name"]) 
        &&  isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["confirm_password"])) {

        $connessione = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]) or die(mysqli_connect_error($connessione));

        $username = mysqli_real_escape_string($connessione, $_POST["username"]);
        $query = "SELECT * FROM USERS WHERE username = '$username'";

        $res = mysqli_query($connessione, $query);

        if (mysqli_num_rows($res) > 0) {
            $errore = "Nome utente già utilizzato";
        } else {

            $email = mysqli_real_escape_string($connessione, strtolower($_POST["email"]));
            $query = "SELECT * FROM USERS WHERE EMAIL = '$email'";

            $res = mysqli_query($connessione, $query);

            if (mysqli_num_rows($res) > 0) {
                $errore = "Email già utilizzata";
            } else {

                if (strlen($_POST["password"]) < 8) {
                    $errore = "Caratteri password insufficienti";
                } else {

                    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
                        $errore = "Le due password non coincidono";
                    } else {

                        $name = mysqli_real_escape_string($connessione, $_POST['name']);
                        $surname = mysqli_real_escape_string($connessione, $_POST['surname']);
                        $password = mysqli_real_escape_string($connessione, $_POST['password']);
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        
                        $query = "INSERT INTO USERS(name, surname, email, username, password) VALUES ('$name', '$surname', '$email', '$username','$password')";

                        $res = mysqli_query($connessione, $query);

                        if (!$res) {
                            $errore = "Errore di connessione al database";
                        } else {
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['id'] = mysqli_insert_id($connessione);
                            $_SESSION['name'] = $_POST['name'];
                            $_SESSION['surname'] = $_POST['surname'];
                            
                            mysqli_close($connessione);
                            header("Location: home.php");
                            exit;
                        }
                    }
                }
            }
        }
    } else {
        $error = "Errore! Devi compilare tutti i campi.";
    }
}
?>



<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione a LV</title>
    <link rel="stylesheet" href="./signup.css">
    <link rel="stylesheet" href="./index.css">
    <script src="./signup.js" defer></script>
</head>

<body>
    <?php require_once('./navbar.php'); ?>
    <div class="title_container center_object">
        <h2>CREARE UN ACCOUNT MY LV</h2>
        <h4>DATI PER LA REGISTRAZIONE</h4>
    </div>

    <div class="center_object">
        <?php if (isset($errore)) {
            echo "<h4 id='errore'>" . $errore . "</h4>";
        } ?>
    </div>
    
    <div class="account_exist_container center_object">
        <p>Hai già un account? <a class="underline" href="./login.php">Accedi</a></p>
    </div>


    <div class="form_container center_object">
        <form action="./signup.php" name="register" method="post">
            <div class="form_item name">
                <label>Nome<div class="form_item_input"><input type="text" name="name" required placeholder="Inserisci il tuo nome"></div></label>
            </div>
            <div class="form_item surname">
                <label>Cognome<div class="form_item_input"><input type="text" name="surname" required placeholder="Inserisci il tuo cognome"></div></label>
            </div>
            <div class="form_item username">
                <label>Nome Utente<div class="form_item_input"><input type="text" name="username" required placeholder="Scegli il tuo nome utente"></div></label>
            </div>
            <div class="form_item email">
                <label>Email<div class="form_item_input"><input type="email" name="email" required placeholder="Inserisci la tua email"></div></label>
            </div>
            <div class="form_item password">
                <label>Password<div class="form_item_input"><input type="password" name="password" required placeholder="Scegli la password"></div></label>
            </div>
            <div class="form_item password_confirm">
                <label>Conferma Password<div class="form_item_input"><input type="password" name="confirm_password" required placeholder="Conefma la tua password"></div></label>
            </div>
            <div class="form_submit center_object">
                <label><input type="submit" name="submit"></label>
            </div>
        </form>
    </div>

    <?php require_once('./footer.php'); ?>
    <?php require_once('./footer_phone.php'); ?>

</body>

</html>