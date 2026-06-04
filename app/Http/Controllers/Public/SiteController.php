<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Produto;

class SiteController extends Controller
{
    public function index()
    {
        //
        $produtos = Product::paginate(6);
        return view('index', compact('produtos'));
    }
}
