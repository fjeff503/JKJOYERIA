<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Provider;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('admin.product.create', compact('categories', 'providers'));
    }

    public function store(StoreProductRequest $request)
    {
        //este toma los parametros y reglas pa guardar del Http\Requests\Provider\StoreProviderRequest
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function show(Product $provider)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $provider)
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('admin.product.show', compact('categories', 'providers', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
