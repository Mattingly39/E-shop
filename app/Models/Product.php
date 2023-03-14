<?php

namespace App\Models;

use PDO;

class Product extends Model
{

    public function listProducts($start_from, $num_per_page)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'SELECT * FROM products WHERE display = 1 LIMIT '.$start_from.','.$num_per_page.'';
            $query = $connection ->prepare($sql);
            $query->execute();
            $products = $query->fetchAll();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        return $products;
    }

    public function getProduct($id)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'SELECT * FROM products WHERE id='.$id.'';
            $query = $connection ->prepare($sql);
            $query->execute();
            $products = $query->fetch();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        return $products;
    }

    public function countProducts()
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'SELECT COUNT(*) FROM products WHERE display = 1';
            $query = $connection ->prepare($sql);
            $query->execute();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        return $query->fetchColumn();
    }

    public function addBasket($userID, $productID)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'INSERT INTO basket(`userID`, `productID`) VALUES(:userID, :productID)';
            $query = $connection ->prepare($sql);
            $query->bindValue(':userID', $userID, PDO::PARAM_INT);
            $query->bindValue(':productID', $productID, PDO::PARAM_INT);
            return $query->execute();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
    }

    public function emptyCart($userID)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'DELETE FROM basket WHERE userID = '.$userID.'';
            $query = $connection ->prepare($sql);
            return $query->execute();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
    }

    public function updateCart($userID, $productID)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'BEGIN
            SET ROWCOUNT 1 
            DELETE FROM basket WHERE userID = '.$userID.' AND productID = '.$productID.'
            SET ROWCOUNT 0 
            END';
            $query = $connection ->prepare($sql);
            return $query->execute();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
    }



    public function getBasket($userID)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'SELECT DISTINCT * FROM basket INNER JOIN products ON products.id = basket.productID WHERE userID='.$userID.'';
            $query = $connection ->prepare($sql);
            $query->execute();
            $cart = $query->fetchAll();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        return $cart;
    }


    function compteurproducts($userID)
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
      $sql1 = 'DROP VIEW compteurproducts';
       $stmt= $connection->prepare($sql1);
       $stmt->execute();
       $compteurproducts='CREATE VIEW compteurproducts AS
        SELECT id, product_name, image, reference, price
        FROM basket INNER JOIN products ON products.id = basket.productID WHERE userID='.$userID.'';
       $stmt= $connection->prepare($compteurproducts);
       $stmt->execute();
       $compteur = 'SELECT id, COUNT(id) AS count1 FROM compteurproducts GROUP BY id;';
       $req3 = $connection->query($compteur);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
    return $req3->fetchAll();
    }

    public function count(): string
    {
        return '/resources/templates/count.php';
    }


}