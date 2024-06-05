<?php

require_once './dbconfig.php';
require_once './check_login.php';


header('Content-Type: application/json');

$response = array('success' => false);



if (!(checkLogin())) {
   $response["success"] = 'login_problem';
   echo json_encode($response);
   exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (isset($_POST["product_id"]) && isset($_SESSION["id"])) {

      $product_id = $_POST["product_id"];
      $client_id = $_SESSION["id"];
   } else {
      echo json_encode($response);
      exit;
   }

   $connection = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]) or die(mysqli_connect_error());

   $query = "SELECT * FROM cart_item as ci join cart as c on ci.cart_id = c.id where ci.product_id = $product_id and c.client_id = $client_id";

   $res = mysqli_query($connection, $query);
 
   if (mysqli_num_rows($res) > 0) {

      $row = mysqli_fetch_assoc($res);
      $quantity = $row["quantity"];
      $cart_id = $row["cart_id"];

      $query = "UPDATE cart_item set quantity = $quantity + 1 where cart_id = $cart_id";

      mysqli_query($connection, $query) or die(mysqli_connect_error());
      
      $response['success'] = true;

   }else {

      $query = "INSERT INTO cart(client_id) values($client_id)";

      mysqli_query($connection, $query) or die(mysqli_connect_error());

      $cart_id = mysqli_insert_id($connection);
      $quantity = 1;

      $query = "INSERT INTO cart_item(product_id, cart_id, quantity) values($product_id, $cart_id, $quantity)";

      mysqli_query($connection, $query) or die(mysqli_connect_error());

      $response['success'] = true;

   }
   
    mysqli_close($connection);
    echo json_encode($response);

}
