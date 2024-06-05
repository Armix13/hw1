<?php

require_once './dbconfig.php';
require_once './check_login.php';

if (!(checkLogin())) {
    header('Location: login.php');
    exit;
}

$conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]);

if (!$conn) {
    die(mysqli_connect_error());
}

$client_id = $_SESSION["id"];

$query = "SELECT id from cart where client_id = $client_id";

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>





<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./cart.css">
    <script src="./cart.js" defer></script>
</head>

<body>

    <?php require_once './navbar.php'; ?>

    <?php if (mysqli_num_rows($res) > 0) 
    {  
    ?>
    <div class="cart_container">
        <div class="cart">
            <?php
                $totale = 0;

                while ($row = mysqli_fetch_assoc($res)) {

                    $cart_id = $row["id"];

                    $query = "SELECT * FROM cart_item as ci join products as p on ci.product_id = p.id where cart_id = $cart_id";

                    $newRes = mysqli_query($conn, $query);

                    $product = mysqli_fetch_assoc($newRes);

            ?>

                <div class="cart_item">
                    <div class="product_name"><?php echo $product["name"]   ?></div>
                    <div class="product_price"><?php echo $product["price"]?> €</div>
                    <div class="product_quantity">
                        <input type="hidden" name="product_id" value="<?php echo $product["product_id"] ?>">
                        <button type="button" class="quantity_btn" name="decrease_quantity" data-action="decrease">-</button>
                        <input name="quantity_value" type="text" value="<?php echo $product["quantity"]   ?>" readonly>
                        <button type="button" class="quantity_btn" name="increase_quantity" data-action="increase">+</button>
                    </div>
                    <div class="total_price">
                        <?php
                            $totaleProdotto = $product["price"] * $product["quantity"];
                            $totale += $totaleProdotto;
                            echo  $totaleProdotto;
                        ?>
                        €
                    </div>
                </div>

            <!-- Fine while -->   
            <?php
            }
            ?>

            <!-- Totale -->
            <div class="cart_total">
                <div class="total_label">Totale</div>
                <div class="total_amount"><?php echo $totale; ?> €</div>
            </div>
            <!-- Bottone Checkout -->
            <button class="checkout_btn">Procedi al checkout</button>
        </div>     
    </div>
    <!-- Fine if -->
    <?php
    } else {
    ?>
    <div id='no_products'>
        <h2>Nessun prodotto nel carrello</h2>
        <p>Vai a: <a class="underline" href="./products.php">tutti i prodotti</a></p>
    </div>
    <?php
    }
    ?>


<?php require_once './footer.php';  ?>
<?php require_once './footer_phone.php'; ?>

</body>

</html>