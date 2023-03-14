<?php
session_start();
use App\Controllers\EshopController;
use App\Controllers\ProductController;

if(!array_key_exists('count', $_SESSION)) {
    $_SESSION['count'] = 1;
}


require_once './vendor/autoload.php';

$eshop = new EshopController();
$eproduct = new ProductController();

switch (getUri()) {
    case '/':
        echo $eshop->index();
        break;
//    case '/todo':
//        if(!isset($_GET['id'])) {
 //           header('Location: /');
 //           exit;
 //       }
 //       echo $eshop->show($_GET['id']);
 //       break;
//    case '/checked':
//        if(!isset($_GET['id'])) {
//            header('Location: /');
//            exit;
//        }
//        echo $eshop->checked($_GET['id']);
 //       break;
    case '/connection':
        echo $eshop->check();
        break;
    case '/signup':
        echo $eshop->signup();
            break;
    case '/login':
        echo $eshop->login();
        break;
    case '/inscription':
        echo $eshop->inscription();
        break;
}


switch (getUri()) {
    case '/products':
        if(isset($_GET["page"]))
        {
            $page=$_GET["page"];
        } else {
            $page=1;
        }
        if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
        echo $eproduct->products($_SESSION["userConnected"], $page);
        } else {
        echo $eproduct->products([], $page);
        }
        break;

    case '/product':
        if(!isset($_GET['productID'])) {
            header('Location: /');
            exit;
        }
        if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
        echo $eproduct->showProduct($_GET['productID'], $_SESSION["userConnected"]);
        } else {
        echo $eproduct->showProduct($_GET['productID'], []);
        }
        break;

    case '/basket':

        if(!isset($_GET['productID'])) {
            echo $eproduct->showBasket($_SESSION["userConnected"]);
            exit;
        } else {
            header('Location: /basket');
        }
        if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
            echo $eproduct->productBasket($_GET['productID'], $_SESSION["userConnected"]);
        }
        break;

    case '/empty':
        if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
            echo $eproduct->emptyBasket($_SESSION["userConnected"]);
        } else {
            echo $eshop->index();
        }
        break;

    case '/update':
        if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
            echo $eproduct->showBasket($_SESSION["userConnected"]);
        } else {
            echo $eshop->index();
        }
        break;

    case '/increment':
        
        echo $eproduct->increment();
//        echo $eproduct->updateCart($_SESSION["userConnected"], $_GET['productID']);
        break;

}

