<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orders;

    public function __construct(OrderRepositoryInterface $orders)
    {
        $this->orders = $orders;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');

        if ($keyword) {
            $orders = $this->orders->search($keyword, 10);
        } else {
            $orders = $this->orders->paginate(10);
        }

        return view('orders.index', compact('orders', 'keyword'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        $products = \App\Models\Product::all();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'address_place' => 'nullable|string|max:255',
            'status'        => 'nullable|string|in:pending,completed,cancelled',
            'items'         => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            $this->orders->create($validated);
            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $order = $this->orders->find($id);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        return view('orders.show', compact('order'));
    }

    public function edit(int $id)
    {
        $order = $this->orders->find($id);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        $customers = \App\Models\Customer::all();

        return view('orders.edit', compact('order', 'customers'));
    }


    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'address_place' => 'nullable|string|max:255',
            'status'        => 'nullable|string|in:pending,completed,cancelled',
            'items'         => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            $updated = $this->orders->update($id, $validated);

            if (!$updated) {
                return redirect()->route('orders.index')->with('error', 'Update failed.');
            }

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id)
    {
        $deleted = $this->orders->delete($id);

        if (!$deleted) {
            return redirect()->route('orders.index')->with('error', 'Delete failed.');
        }

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
