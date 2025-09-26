<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customers;

    public function __construct(CustomerRepositoryInterface $customers)
    {
        $this->customers = $customers;
    }

    public function index()
    {
        $customers = $this->customers->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $this->customers->create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(int $id)
    {
        $customer = $this->customers->find($id);
        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $updated = $this->customers->update($id, $validated);
        if (!$updated) {
            return redirect()->route('customers.index')->with('error', 'Update failed.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(int $id)
    {
        $deleted = $this->customers->delete($id);
        if (!$deleted) {
            return redirect()->route('customers.index')->with('error', 'Delete failed.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function findByEmailOrName(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $customers = $this->customers->findByEmail($search)->paginate(10);
        } else {
            $customers = $this->customers->paginate(10);
        }

        return view('customers.index', compact('customers', 'search'));
    }
}

