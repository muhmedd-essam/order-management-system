<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id);
    public function findByEmail(string $email);
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
