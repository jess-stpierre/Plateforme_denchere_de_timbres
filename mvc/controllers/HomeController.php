<?php

namespace App\Controllers;

use App\Models\ExampleModel;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class HomeController {

    public function index(){
        return View::render('home');
    }
}

?>