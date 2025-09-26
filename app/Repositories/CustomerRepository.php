<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::remember('customers.all', 60, function () {
            return Customer::select('id','name','email','phone','created_at')->get();
        });
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Customer::select('id','name','email','phone','created_at')->paginate($perPage);
    }

    public function find(int $id)
    {
        return Customer::find($id);
    }

    public function findByEmail(string $value)
    {
        return Customer::query()
            ->where('email', $value)
            ->orWhere('name', 'like', "%{$value}%");
    }

    public function create(array $data)
    {
        $customer = Customer::create($data);
        Cache::forget('customers.all');
        return $customer;
    }

    public function update(int $id, array $data): bool
    {
        $customer = $this->find($id);
        if (!$customer) return false;

        $updated = $customer->update($data);
        Cache::forget('customers.all');
        return $updated;
    }

    public function delete(int $id): bool
    {
        $customer = $this->find($id);
        if (!$customer) return false;

        $deleted = $customer->delete();
        Cache::forget('customers.all');
        return $deleted;
    }
}
