<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    // GET /users
    // public function index(Request $request)
    // {
    //     if ($request->query('paginate')) {
    //         $perPage = (int) $request->query('per_page', 15);
    //         $collection = $this->users->paginate($perPage);
    //         return UserResource::collection($collection);
    //     }

    //     $collection = $this->users->all();
    //     return UserResource::collection($collection);
    // }
}
