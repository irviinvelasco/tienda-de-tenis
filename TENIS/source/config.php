<?php

define("CLIENT_ID","AUqKvEuvKAMHyrHpE_nvORidncgJEWNylAjojzi0ibOojuwWjiu1LoS5eOiQbhiUOESTpZz-ndpqXMpA");
define("CURRENCY","MXN");
define("KEY_TOKEN","SDF_iva/546");
define("MONEDA","$");

session_start();

$num_cart = 0;
if (isset( $_SESSION['carrito']['productos'])){
    $num_cart = count( $_SESSION['carrito']['productos']);    
}

?>