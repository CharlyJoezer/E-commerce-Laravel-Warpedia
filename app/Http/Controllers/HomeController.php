<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function homeView(Request $request)
    {
        $product = Product::paginate(7);
        if ($request->ajax()) {
            $view = view('data', compact('product'))->render();
            return response()->json(['html' => $view]);
        }
        return view('home', [
            'title' => 'Selamat Datang Di Warpedia',
            'css' => 'home.css',
            'js'  => 'home.js',
            'data' => $product
        ]);
    }

    public function viewDetailProduct($id)
    {
        $trueID = $id / 3625;
        $getData = Product::where('id', $trueID)->first();
        return view('detailProduct', [
            'title' => 'Warpedia | Detail Product',
            'css' => 'detailProduct.css',
            'js' => 'detailProduct.js',
            'data' => $getData
        ]);
    }
}
