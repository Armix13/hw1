<?php

require_once './dbconfig.php';
require_once './check_login.php';


if (checkLogin()) {
    header("location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $connection = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]) or die(mysqli_connect_error());
       
        $username = mysqli_real_escape_string($connection, $_POST["username"]);
        $query = "SELECT * FROM USERS WHERE username = '$username'";

        $res = mysqli_query($connection, $query) or die(mysqli_connect_error());
      
        if (mysqli_num_rows($res) > 0) {

            $row = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $row['password'])) {

                $_SESSION["username"] = $username;
                $_SESSION["id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["surname"] = $row["surname"];

                mysqli_close($connection);

                header("Location: home.php");
                exit;
            } else {
                $errore = "Password errata";
            }
        } else {
            $errore = "Username errato.";
        }
    } else {
        $errore = "Inserisci username e password";
    }
}




?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login a LV</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./login.css">
</head>

<body>

    <?php require_once("./navbar.php"); ?>

    <div class="login_title center_object">
        <h2>PER CONTINUARE ACCEDI CON IL TUO ACCOUNT LV</h2>
    </div>

    <div class="error_message_container center_object">
        <?php
        if (isset($errore)) {
            echo "<h4 class='errore_message'>" . $errore . "</h4>";
        }
        ?>
    </div>

    <div class="login_form_container center_object">
        <form name="login" action="./login.php" method="post">
            <div class="login_form_input">
                <label>Nome Utente <input type="text" name="username" required placeholder="Nome utente"></label>
            </div>
            <div class="login_form_input">
                <label>Password <input type="password" name="password" required placeholder="Password"></label>
            </div>
            <div class="login_form_submit center_object">
                <label>&nbsp; <input type="submit" value="Accedi"></label>
            </div>
        </form>
    </div>

    <div class="account_no_exist_container center_object">
        <p>Non hai ancora un account LV? <a href="./signup.php" class="underline">Registrati</a></p>
    </div>

    <?php require_once('./footer.php'); ?>
    <?php require_once('./footer_phone.php'); ?>
</body>

</html>