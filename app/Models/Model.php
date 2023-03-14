<?php

namespace App\Models;

use ORM;

abstract class Model
{
    public function __construct()
    {
        ORM::configure('mysql:host='. CONFIG['database']['host'].';dbname=' . CONFIG['database']['dbname']);
        ORM::configure('username', CONFIG['database']['user']);
        ORM::configure('password', CONFIG['database']['password']);
    }
}
