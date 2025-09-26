<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $products;

    public function __construct(ProductRepositoryInterface $products)
    {

        $this->products = $products;

    }

        public function index(Request $request)
        {
            $keyword = $request->get('search');

            if ($keyword) {
                $products = $this->products->search($keyword, 10);
            } else {
                $products = $this->products->paginate(10);
            }

            return view('products.index', compact('products', 'keyword'));
        }

        public function create()
        {
            return view('products.create');
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            $this->products->create($validated);

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        }

        public function edit(int $id)
        {
            $product = $this->products->find($id);

            if (!$product) {
                return redirect()->route('products.index')
                    ->with('error', 'Product not found.');
            }

            return view('products.edit', compact('product'));
        }

        public function update(Request $request, int $id)
        {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            $updated = $this->products->update($id, $validated);

            if (!$updated) {
                return redirect()->route('products.index')
                    ->with('error', 'Update failed.');
            }

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');
        }

        public function destroy(int $id)
        {
            $deleted = $this->products->delete($id);

            if (!$deleted) {
                return redirect()->route('products.index')
                    ->with('error', 'Delete failed.');
            }

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }
}
