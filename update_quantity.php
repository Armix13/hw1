<?php

require_once './dbconfig.php';
session_start();

header('Content-Type: application/json');



if(!(isset($_SESSION["id"]))){
    echo json_encode(array('success' => 'not id session'));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    
    $data = json_decode(file_get_contents("php://input"), true);

    

    $client_id = $_SESSION["id"];
  
    $product_id = $data["product_id"];  
    $quantity = $data["quantity"];

    
    

    $connessione = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["namedb"]) or die();
    

    $query = "SELECT id FROM cart where client_id = $client_id";

  
  
    $res = mysqli_query($connessione, $query);
    
    $row = mysqli_fetch_assoc($res);

    $cart_id = $row["id"];

  

  

    if($quantity == 1){
        
        $query = "DELETE from cart_item where cart_id = $cart_id";
        mysqli_query($connessione, $query) or die(mysqli_connect_error());

        $query = "DELETE from cart where client_id = $client_id";
        mysqli_query($connessione, $query) or die(mysqli_connect_error());
        
        mysqli_close($connessione);

        echo json_encode(array('success' => 'prodotto rimosso'));
        exit;

    }else {
        
        $query = "UPDATE cart_item SET quantity = $quantity where cart_id = $cart_id";
        mysqli_query($connessione, $query) or die(mysqli_connect_error());

        mysqli_close($connessione);


        echo json_encode(array('success' => 'quantità aggiornata con successo'));
        exit;

    }

}else {

    echo json_encode(array('success' => 'errore invio dati post'));
    exit;

}
?>