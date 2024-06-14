<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index(Request $request)
    {
        // Verificar si la solicitud proviene del enlace de categorías en el menú de navegación
        if ($request->route()->named('categories.index')) {
            // Si la solicitud proviene del enlace de categorías, cargar la vista index.blade.php de categorías
            $categories = Category::all();
            return view('categories.index', compact('categories'));
        } else {
            // Si no, carga la vista home.blade.php normalmente con categorías que tienen productos en stock
            $categories = Category::whereHas('products', function ($query) {
                $query->where('stock', '>', 0);
            })->with(['products' => function ($query) {
                $query->where('stock', '>', 0);
            }])->get();

            return view('home', compact('categories'));
        }
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // Este método está reservado para mostrar el formulario de creación de una nueva categoría
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
{
    // Primero, valido los datos de la solicitud
    $request->validate([
        'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
    ]);

    // Crear una nueva categoría con los datos validados
    Category::create([
        'name' => $request->name,
    ]);

    // Redirijo a la vista de categorías con un mensaje de éxito
    return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
}


    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        // Obtener la categoría con sus productos que tienen stock mayor a 0
        $category = Category::with(['products' => function ($query) {
            $query->where('stock', '>', 0);
        }])->findOrFail($id);

        // Devolver la vista con la categoría especificada
        return view('categories.show', compact('category'));
    }

    /**
     * Mostrar los productos de una categoría que tienen stock mayor a 0.
     */
    public function showProducts(Category $category)
    {
        $products = $category->products()->where('stock', '>', 0)->get();
        return view('categories.show', compact('category', 'products'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit($id)
    {
        // Obtener la categoría especificada para edición
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'name' => 'required',
        ]);

        // Obtener y actualizar la categoría especificada con los datos validados
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        // Redirigir a la vista de categorías con un mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        // Eliminar la categoría especificada
        Category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
