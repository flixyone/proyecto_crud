<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Defino los atributos que se pueden asignar de manera masiva
    protected $fillable = [
        'user_id', 'product_id', 'quantity',
    ];

    /**
     * Defino la relación con el modelo Product.
     * Un ítem del carrito pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Defino la relación con el modelo User.
     * Un ítem del carrito pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
