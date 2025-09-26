<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return Cache::remember('users.all', 60, function () {
            return User::select('id','name','email','created_at')->get();
        });
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::select('id','name','email','created_at')->paginate($perPage);
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        $user = User::create($data);
        Cache::forget('users.all');
        return $user;
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        if (!$user) return false;
        $updated = $user->update($data);
        Cache::forget('users.all');
        return $updated;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) return false;
        $deleted = $user->delete();
        Cache::forget('users.all');
        return $deleted;
    }
}
