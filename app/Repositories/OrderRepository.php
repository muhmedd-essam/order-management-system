<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::remember('orders.all', 60, function () {
            return Order::with(['customer', 'items.product'])->get();
        });
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Order::with(['customer', 'items.product'])->paginate($perPage);
    }

    public function find(int $id)
    {
        return Order::with(['customer', 'items.product'])->find($id);
    }

    public function search(string $keyword, int $perPage = 15): LengthAwarePaginator
    {
        return Order::with(['customer', 'items.product'])
            ->whereHas('customer', function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->orWhere('status', 'like', "%{$keyword}%")
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_id'   => $data['customer_id'],
                'status'        => $data['status'] ?? 'pending',
                'address_place' => $data['address_place'] ?? null,
                'total'         => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for product {$product->name}");
                }

                $product->decrement('stock', $item['quantity']);

                $price = $product->price * $item['quantity'];
                $total += $price;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            $order->update(['total' => $total]);

            return $order;
        });

        Cache::forget('orders.all');
        return $order;
    }

    public function update(int $id, array $data): bool
    {
        $updated = DB::transaction(function () use ($id, $data) {
            $order = Order::find($id);
            if (!$order) return false;

            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            $order->items()->delete();

            $total = 0;
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for product {$product->name}");
                }

                $product->decrement('stock', $item['quantity']);

                $price = $product->price * $item['quantity'];
                $total += $price;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            return $order->update([
                'customer_id'   => $data['customer_id'],
                'status'        => $data['status'] ?? $order->status,
                'address_place' => $data['address_place'] ?? $order->address_place,
                'total'         => $total,
            ]);
        });

        Cache::forget('orders.all');
        return $updated;
    }

    public function delete(int $id): bool
    {
        $order = Order::find($id);
        if (!$order) return false;

        $deleted = DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            $order->items()->delete();
            return $order->delete();
        });

        Cache::forget('orders.all');
        return $deleted;
    }
}
