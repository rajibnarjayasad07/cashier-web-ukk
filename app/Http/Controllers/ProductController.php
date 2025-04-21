<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('sharingpage.product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->storeAs('products', $filename, 'public');
                $data['image'] = $filename;
            }

            Product::create($data);
            return redirect()->route('product')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product')->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(id $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->storeAs('products', $filename, 'public');
                $data['image'] = $filename;
            }

            $product->update($data);
            return redirect()->route('product')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product')->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Update the stock of the specified resource.
     */
    public function updateStock(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update(['stock' => $request->input('stock')]);

            return redirect()->route('product')->with('success', 'Stock updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product')->with('error', 'Failed to update stock: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('product')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
