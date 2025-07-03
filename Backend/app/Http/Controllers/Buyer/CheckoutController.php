<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        $items = $request->input('items');
        $totalPrice = 0;
        $orderItems = [];

        DB::beginTransaction();

        try {
            foreach ($items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);

                if ($product->stock < $itemData['quantity']) {
                    return response()->json(['error' => "Insufficient stock for {$product->title}"], 400);
                }

                $unitPrice = $product->price;
                $quantity = $itemData['quantity'];
                $total = $unitPrice * $quantity;

                $orderItems[] = new OrderItem([
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $total,
                    'product_snapshot' => $product->toArray(),
                ]);

                $totalPrice += $total;

                // Deduct stock
                $product->decrement('stock', $quantity);
            }

            $order = Order::create([
                'buyer_id' => auth()->id(),
                'subtotal' => $totalPrice,
                'tax_amount' => 0,
                'shipping_fee' => 0,
                'total_price' => $totalPrice,
                'payment_method' => $request->input('payment_method'),
                'shipping_address' => $request->input('shipping_address'),
                'billing_address' => $request->input('billing_address'),
                'notes' => $request->input('notes'),
                'status' => 'pending',
            ]);

            $order->items()->saveMany($orderItems);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order creation failed.', 'message' => $e->getMessage()], 500);
        }

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\OrderResource($order),
            'Order placed successfully.',
            201
        );
    }
}
