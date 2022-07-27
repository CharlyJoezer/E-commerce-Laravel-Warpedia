<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homeView(){
        return view('home', [
            'title' => 'Selamat Datang Di Warpedia',
            'css' => 'home.css',
            'js'  => 'home.js'
        ]);
    }
}
