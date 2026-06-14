<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Criar o usuário administrador manual
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'role' => UserRole::SUPER_ADMIN
        ]);

        // 2. NOVO: Criar o usuário CLIENTE manual para testes locais
        $clientUser = User::factory()->create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@example.com',
            'password' => bcrypt('cliente'), // Senha fácil de lembrar para o login
        ]);

        // 3. Criar os outros 15 usuários genéricos em massa
        $randomUsers = User::factory(15)->create();

        // JUNTA TODOS (Admin, Cliente de Teste e Aleatórios) na mesma coleção
        $allUsers = collect([$adminUser, $clientUser])->merge($randomUsers);

        // 4. Criar as Categorias
        $categories = Category::factory(8)->create();

        // 5. Criar os Produtos associados a essa base
        $products = Product::factory(40)->create([
            'user_id' => fn () => $allUsers->random()->id,
            'category_id' => fn () => $categories->random()->id,
        ]);

        // 6. Adicionar imagens falsas para os produtos criados
        $products->each(function ($product) {
            DB::table('product_images')->insert([
                [
                    'product_id' => $product->id,
                    'url' => 'https://picsum.photos/640/480?random=' . rand(1, 1000),
                ],
                [
                    'product_id' => $product->id,
                    'url' => 'https://picsum.photos/640/480?random=' . rand(1001, 2000),
                ]
            ]);
        });

        // 7. Criar Pedidos amarrados a qualquer usuário (o seu cliente vai ganhar histórico de compras aqui!)
        Order::factory(30)->create([ // Aumentei para 30 para garantir mais chance de pedidos para todos
            'user_id' => fn () => $allUsers->random()->id,
        ])->each(function ($order) use ($products) {
            
            $produtosAleatorios = $products->random(rand(1, 4));

            foreach ($produtosAleatorios as $product) {
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'unit_price' => $product->price,
                ]);
            }
        });

        // 8. Popular algumas Wishlists (o seu cliente também vai ganhar favoritos aleatórios)
        foreach (range(1, 40) as $index) {
            DB::table('wishlist')->insertOrIgnore([
                'user_id' => $allUsers->random()->id,
                'product_id' => $products->random()->id,
            ]);
        }
    }
}