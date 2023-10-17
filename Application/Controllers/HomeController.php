<?php

namespace Demo\Application\Controllers;

use Demo\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('index');
    }


}