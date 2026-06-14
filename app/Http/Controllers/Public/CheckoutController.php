<?php

namespace App\Http\Controllers\Public;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Mostrar a página de revisão do pedido antes de finalizar.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // Se o carrinho estiver vazio, não há nada para finalizar
        if (empty($cart)) {
            return redirect()->route('carrinho.index')->with('error', 'O seu carrinho está vazio.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('public.checkout.index', compact('cart', 'total'));
    }

    /**
     * Processar o pedido, salvar na BD e dar baixa no stock.
     */
    public function processar(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('carrinho.index')->with('error', 'O seu carrinho está vazio.');
        }

        // 💡 VALIDAR OS DADOS DE CONTACTO E ENTREGA
        $request->validate([
            'phone' => 'required|string|min:9|max:15',
            'province' => 'required|string|max:50',
            'address' => 'required|string|max:500',
        ], [
            'phone.required' => 'O número de telefone é obrigatório para podermos ligar a confirmar.',
            'address.required' => 'Por favor, indique o seu endereço ou ponto de referência para a entrega.',
        ]);

        DB::beginTransaction();

        try {
            $totalGeral = 0;
            $itemsParaSalvar = [];

            

            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if (!$product || $product->stock < $item['quantity']) {
                    return redirect()->route('carrinho.index')->with('error', "Produto indisponível ou sem stock suficiente.");
                }

                

                $totalGeral += $product->price * $item['quantity'];
                $itemsParaSalvar[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ];
            }

            ///dd(auth()->id());

            // O teu primeiro dd que funciona (podes comentar ou apagar)
            // dd([...]); 

            try {
                // 💡 CRIA A ENCOMENDA GUARDANDO O TELEFONE E ENDEREÇO
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $totalGeral,
                    'status' => OrderStatus::PENDING, // 💡 AJUSTE 1: Usa ->value para garantir que vai como string ('pending')
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'province' => $request->province
                ]);
            } catch (\Exception $e) {
                // 💡 AJUSTE 2: Se o Order::create falhar, este dd vai parar tudo e mostrar-te o motivo real!
                dd([
                    'Mensagem de Erro' => $e->getMessage(),
                    'Linha do Erro' => $e->getLine(),
                    'Ficheiro' => $e->getFile()
                ]);
            }

            foreach ($itemsParaSalvar as $itemData) {
                $order->items()->create($itemData);
                Product::find($itemData['product_id'])->decrement('stock', $itemData['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('checkout.sucesso', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrinho.index')->with('error', 'Erro ao processar o pedido.');
        }
    }

    /**
     * Mostrar o ecrã de sucesso após finalizar a compra.
     */
    public function sucesso(Order $order)
    {
        // Segurança: Garante que o cliente só consegue ver o seu próprio recibo de sucesso
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('public.checkout.sucesso', compact('order'));
    }
}