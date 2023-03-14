<?php

namespace App\Models;

use PDO;

class User extends Model
{
    static protected string $table = 'user';

    public function checkUser($name) 
    {
        try {
            $root = realpath($_SERVER["DOCUMENT_ROOT"]);
            require "$root/db.php";
            $sql = 'SELECT * FROM user WHERE name = :name;';
            $query = $connection ->prepare($sql);
            $query->bindValue(':name',$name, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
        }
        return $user;
    }

    public function insertUser($name, $password) : bool
    {
    try {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require "$root/db.php";
        $sql = 'INSERT INTO user(`name`, `password`) VALUES(:name, :password)';
        $query = $connection->prepare($sql);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        return $query->execute();
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage() . '<br/>';
    }
    }
  
    
}
