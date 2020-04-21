<?php
require("./controller/ProductsController.php");
$controller = new ProductsController;
session_start();

$controller->handleRequest();
?>