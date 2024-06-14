<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Defino los atributos que se pueden asignar de manera masiva
    protected $fillable = ['name'];

    /**
     * Defino la relación con el modelo Product.
     * Una categoría puede tener muchos productos.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
