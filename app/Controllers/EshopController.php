<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Product;
class EshopController extends Controller
{
    public function index(): string
    {
        if(isset($_GET['deConnected']) AND !empty($_GET['deConnected'])) {
            if($_GET['deConnected'] == 1) {
                session_destroy();
 //               unset($_SESSION['userConnected']);
                $user = [];
            }
            else {
                $user['name'] = $_SESSION["userConnected"];
            }
        } else {
            if(isset($_SESSION["userConnected"])){
            $user = $_SESSION["userConnected"];
        } else {
            $user = [];
        }
        }
        $products = new Product();
  //      $cart = $products->getBasket($user["id"]);
        return $this->template->render('home.html', [
            'user'=>$user,
   //         'cartproducts' => $cart,
        ]);
    }

    public function login(): string
    {
        return $this->template->render('components/login.html');
    }

    public function signup(): string
    {
        return $this->template->render('components/signup.html');
    }

    public function check(): string
    {
        $checkFieldsConn = new Validator();
        $checkFieldsConn = $checkFieldsConn->validate(
            [
                'name' => ['required', 'max255'],
                'password' => ['required', 'max50'],
            ]
           );

           if($checkFieldsConn == ""){
            $user = new User();
            $user = $user->checkUser($_POST['name']);
            if ($user) {
                if (!password_verify($_POST['password'], $user['password'])) {
                  $checkFieldsConn = $checkFieldsConn . "Mauvais mot de passe" ;
                  return $this->template->render('components/login.html', [
                    'checkFieldsConn'=>$checkFieldsConn,
                ]);
                } 
                else {
                  $_SESSION["userConnected"] = $user;
                  return $this->template->render('eshop/checked.html', [
                    'checkFieldsConn'=>$checkFieldsConn,
                    'user'=>$user,
                ]);
                }
            } else {
               $checkFieldsConn = $checkFieldsConn . "Ce nom d'utilisateur n'existe pas" ;
               return $this->template->render('components/login.html', [
                'checkFieldsConn'=>$checkFieldsConn,
            ]);
            }
         }
    }

    public function inscription(): string
    {
    $checkFieldsInsc = new Validator();
    $checkFieldsInsc = $checkFieldsInsc->validate(
        [
           'name' => ['required', 'max50'],
           'password' => ['required', 'max50'],
        ]
       );
       
       $OkInsc = "";
       if($checkFieldsInsc == ""){
        $name = new User();
          $name = $name->checkUser($_POST['name']);
         if ($name) {
             $checkFieldsInsc = $checkFieldsInsc . "Ce nom d'utilisateur existe déjà";
             return $this->template->render('components/signup.html', [
                'checkFieldsConn'=>$checkFieldsInsc,
             ]);
          } 
          else {
            $insertUser = new User();
            $insertUser = $insertUser->insertUser(strip_tags($_POST['name']), password_hash( strip_tags($_POST['password']), PASSWORD_DEFAULT));
             if (!$insertUser) {
                $checkFieldsInsc = $checkFieldsInsc . "Le nouvel utilisateur n'a pas pu être ajouté" ;
                return $this->template->render('home.html', [
                    'checkFieldsConn'=>$checkFieldsInsc,
                 ]);
             }
             else {
                $OkInsc =  "Votre compte a bien été ajouté" ;
                return $this->template->render('components/login.html', [
                    'checkFieldsConn'=>$OkInsc,
                 ]);
             }
          }
       }
    }
}
