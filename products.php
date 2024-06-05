<?php

require_once './dbconfig.php';

$connection = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]) or die(mysqli_connect_error());

$query = "SELECT * FROM products";

$res = mysqli_query($connection, $query);

mysqli_close($connection);
?>



<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodotti</title>
    <link rel="stylesheet" href="./products.css">
    <link rel="stylesheet" href="./index.css">
    <script src="./products_add_to_cart.js" defer></script>
</head>

<body>

    <?php require_once './navbar.php'; ?>

    <!-- Product Container -->
    <div class="content">
        <div class="center_object"><h2>Scopri i prodotti LV</h2></div>

        <div class="product_container">

            <?php
                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)){
            ?>
            <div class="product_card">
                <div class="product_title"><?php echo $row["name"]; ?></div>
                <div class="product_image"><img src="./products_photo/<?php echo $row["img"];?>"></div>
                <div class="product_description"><?php echo $row["description"];?></div>
                <div class="product_price">€ <?php echo $row["price"];?></div>
                <div class="button_product">
                    <form action="./products_add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row["id"];?>">
                        <button class="btn_submit" type="submit">Aggiungi al carrello</button>
                    </form>
                </div>
            </div>
            <?php
                    }
                }else {
                    echo "<p>Nessun prodotto disponibile</p>";
                }
            ?>

        </div>
    </div>

    <?php require_once './footer.php'; ?>
    <?php require_once './footer_phone.php'; ?>

</body>

</html>