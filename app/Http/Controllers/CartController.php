<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Método para mostrar los elementos del carrito
    public function index()
    {
        // Obtener los elementos del carrito del usuario actual, incluyendo la información del producto
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        // Inicializar la cantidad total de productos en el carrito
        $totalQuantity = 0;
        $totalQuantity += $cartItems->sum('quantity'); // Sumar las cantidades de todos los elementos del carrito

        // Calcular el precio total de los productos en el carrito
        $totalPrice = $cartItems->sum(function ($cartItem) {
            $product = optional($cartItem->product); // Obtener el producto opcionalmente (puede ser nulo)
            return $product->price * $cartItem->quantity; // Multiplicar el precio del producto por la cantidad
        });

        // Devolver la vista del carrito con los elementos, la cantidad total y el precio total
        return view('cart.index', compact('cartItems', 'totalQuantity', 'totalPrice'));
    }

    // Método para añadir un producto al carrito
    public function add(Request $request, Product $product)
    {
        // Buscar o crear un elemento del carrito para el usuario actual y el producto especificado
        $cartItem = CartItem::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => 0] // Inicializar la cantidad en 0 si es un nuevo elemento
        );

        // Verificar si la cantidad actual en el carrito junto con la cantidad solicitada excede el stock disponible
        if (($cartItem->quantity + 1) > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'No hay mas unidades disponibles en stock.');
        }

        $cartItem->quantity += 1; // Incrementar la cantidad del producto en el carrito
        $cartItem->save(); // Guardar el elemento del carrito

        // Redirigir a la vista del carrito con un mensaje de éxito
        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito');
    }

    // Método para eliminar un producto del carrito
    public function remove(CartItem $cartItem)
{
    if ($cartItem->user_id == Auth::id()) {
        $cartItem->delete();
        return response()->json(['success' => 'Producto eliminado del carrito'], 200);
    }

    return response()->json(['error' => 'No puedes eliminar este producto del carrito'], 403);
}


    // Método para actualizar la cantidad de un producto en el carrito
    public function update(Request $request, CartItem $cartItem)
{
    // Verificar si el elemento del carrito pertenece al usuario actual
    if ($cartItem->user_id == Auth::id()) {
        // Verificar si la cantidad solicitada excede el stock disponible
        if ($request->quantity > $cartItem->product->stock) {
            return response()->json(['error' => 'La cantidad solicitada excede el stock disponible.'], 400);
        }

        $cartItem->quantity = $request->quantity; // Actualizar la cantidad del producto en el carrito
        $cartItem->save(); // Guardar el elemento del carrito

        // Devolver una respuesta exitosa con los datos actualizados
        return response()->json(['success' => 'Cantidad actualizada', 'cartItem' => $cartItem], 200);
    }

    // Devolver una respuesta de error si la cantidad no puede ser actualizada
    return response()->json(['error' => 'No puedes actualizar este producto del carrito'], 403);
}

}
