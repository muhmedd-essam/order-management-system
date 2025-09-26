<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::remember('products.all', 60, function () {
            return Product::select('id','name','price','stock','created_at')->get();
        });
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Product::select('id','name','price','stock','created_at')->paginate($perPage);
    }

    public function find(int $id)
    {
        return Product::find($id);
    }

    public function search(string $keyword, int $perPage = 15): LengthAwarePaginator
    {
        return Product::query()
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('price', 'like', "%{$keyword}%")
            ->orWhere('stock', 'like', "%{$keyword}%")
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        $product = Product::create($data);
        Cache::forget('products.all');
        return $product;
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        if (!$product) return false;

        $updated = $product->update($data);
        Cache::forget('products.all');
        return $updated;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        if (!$product) return false;

        $deleted = $product->delete();
        Cache::forget('products.all');
        return $deleted;
    }
}
