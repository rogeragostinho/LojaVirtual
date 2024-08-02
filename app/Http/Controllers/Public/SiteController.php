<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Produto;

class SiteController extends Controller
{
    public function index()
    {
        //
        $produtos = Produto::paginate(6);
        return view('index', compact('produtos'));
    }
}
