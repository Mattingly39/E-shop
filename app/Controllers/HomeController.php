<?php

namespace App\Controllers;

class HomeController
{
    public function home(): string
    {
        return './resources/templates/home.php';
    }

    public function count(): string
    {
        return './resources/templates/count.php';
    }

    public function increment(): string
    {
        $_SESSION['count']++;

        return json_encode(['count' => $_SESSION['count']]);
    }

    public function name(): string
    {
        $data = json_decode(file_get_contents('php://input', 'r'));

        // $data->user contient le user
        // enregistrement en base, etc

        return json_encode(['data' => 'Envoyé !']);
    }
}
