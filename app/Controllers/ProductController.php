<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function products($user, $page) : string
    {
        $products = new Product();
        $cart = $products->getBasket($user["id"]);
        $num_per_page=4;
        $start_from=($page-1)*4;
        $total_records=$products->countProducts();   
        $total_pages=ceil($total_records/$num_per_page);
        $prev = $page - 1;
        $next = $page + 1;
        $to = $start_from + $num_per_page;
        if ($to >= $total_records){
            $to = $total_records;
        }
        if ($total_records == 0){
            $start_from = -1;
        };
        $pagination = [
        'previous' => 'products?page='.$prev.'',
        'next' => 'products?page='.$next.'',
        'page' => 'products?page=',
        'total' => ''.$total_records.'',
        'from' => $start_from + 1,
        'to' => ''.$to.'',
        ];

        $products = $products->listProducts($start_from, $num_per_page);
 //       var_dump($products);
        return $this->template->render('components/products.html', [
            'products'=>$products,
            'user'=>$user,
            'pagination' => $pagination,
            'totalpages'=>$total_pages,
            'page'=>$page,
            'cartproducts' => $cart,
        ]);
    }

    public function showProduct(int $id, $user): string
    {
        $product = new Product();
        $compteur = $product->compteurproducts($user["id"]);
        $product = $product->getProduct($id);
        return $this->template->render('components/product.html', [
            'product' => $product,
            'compteurs' => $compteur,
            'user'=>$user,

        ]);
    }
    public function productBasket(int $productID, $user): string
    {
        $product = new Product();
        $compteur = $product->compteurproducts($user["id"]);
        $product2 = $product->addBasket($user["id"], $productID);
        $cart = $product->getBasket($user["id"]);
        
        return $this->template->render('components/basket.html', [
            'cartproducts' => $cart,
            'compteurs' => $compteur,
            'user'=>$user,

        ]);
    }

    public function showBasket($user): string
    {
        $product = new Product();
        $cart = $product->getBasket($user["id"]);
        $compteur = $product->compteurproducts($user["id"]);
        return $this->template->render('components/basket.html', [
            'cartproducts' => $cart,
            'compteurs' => $compteur,
            'user'=>$user,

        ]);
    }

    public function emptyBasket($user): string
    {
        $product = new Product();
        $emptycart = $product->emptyCart($user["id"]);
        $cart = $product->getBasket($user["id"]);
        return $this->template->render('components/basket.html', [
            'cartproducts' => $cart,
            'user'=>$user,

        ]);
    }
    
    public function increment(): string
    {
        $_SESSION['count']++;
        return json_encode(['count' => $_SESSION['count']]);
    }

}