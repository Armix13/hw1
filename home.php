<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./home.css">
</head>

<body>
    <?php require_once("./navbar.php"); ?>

    <div class="logout_button_container">
        <button class="logout_button" type="button"><a href="./logout.php">LOGOUT</a></button>
    </div>

    <div class="welcome_message_container center_object">
        <h1 id="welcome_message">Benvenuto nella home di louis vuitton sg.re
            <?php
            session_start();
            echo $_SESSION['name'] . ' ' . $_SESSION['surname'];
            ?>
        </h1>
    </div>


    <?php require_once './footer.php'; ?>
    <?php require_once './footer_phone.php'; ?>

</body>

</html>