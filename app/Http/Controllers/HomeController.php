<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías que tienen al menos un producto asociado
        $categories = Category::has('products')->with('products')->get();

        // Devolver la vista 'home' con las categorías obtenidas
        return view('home', compact('categories'));
    }
}
