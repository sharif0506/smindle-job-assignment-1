<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        $validatedOrderFields = $request->validated();

        $order = Order::create($validatedOrderFields);

        foreach ($request->basket as $item) {
            $order->baskets()->create($item);
        }

        // Handle subscription items asynchronously if needed
        foreach ($request->basket as $item) {
            if ($item['type'] === 'subscription') {
                ProcessSubscriptionOrder::dispatch($item);
            }
        }

        return response()->json(['message' => 'Order saved successfully'], 201);
    }

    private function handleSubscriptionAsync($item): void
    {
        Queue::push(function () use ($item) {
            $payload = [
                'ProductName' => $item['name'],
                'Price' => $item['price'],
                'Timestamp' => now(),
            ];
            Http::post('https://very-slow-api.com/orders', $payload);
        });
    }
}
