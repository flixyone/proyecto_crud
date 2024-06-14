<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        // Aquí obtengo todos los productos que tienen stock mayor a 0
        $products = Product::where('stock', '>', 0)->get();
        // También obtengo todas las categorías
        $categories = Category::all();

        // Devuelvo la vista 'products.index' con los productos y categorías obtenidos
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Primero, valido los datos de la solicitud
        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'description' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Manejo la imagen del producto si se ha subido una
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        // Creo un nuevo producto con los datos validados
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imageName
        ]);

        // Redirijo a la vista de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        // Obtengo el producto especificado por su id
        $product = Product::findOrFail($id);

        // Devuelvo la vista 'products.show' con el producto obtenido
        return view('products.show', compact('product'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit($id)
    {
        // Obtengo el producto especificado por su id
        $product = Product::findOrFail($id);
        // También obtengo todas las categorías
        $categories = Category::all();

        // Devuelvo la vista 'products.edit' con el producto y las categorías obtenidas
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Primero, valido los datos de la solicitud
        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'description' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Obtengo el producto especificado por su id
        $product = Product::findOrFail($id);

        // Manejo la imagen del producto si se ha subido una nueva
        $imageName = $product->image;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        // Actualizo el producto con los datos validados
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imageName
        ]);

        // Redirijo a la vista de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        // Obtengo el producto especificado por su id
        $product = Product::findOrFail($id);

        // Elimino la imagen del producto si existe
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        // Elimino el producto
        $product->delete();

        // Redirijo a la vista de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
