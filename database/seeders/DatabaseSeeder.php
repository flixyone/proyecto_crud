<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar al RoleSeeder
        $this->call(RoleSeeder::class);

        // Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        // Crear 10 categorías
        Category::factory(10)->create()->each(function ($category) {
            // Para cada categoría, crear entre 1 y 10 productos
            Product::factory(rand(1, 10))->create(['category_id' => $category->id]);
        });
    }
}
