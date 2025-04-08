<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.product.index', compact('products'));
    }

    public function showAll()
    {
        $products = Product::all();

        return view('end_user.product.showAll', compact('products'));
    }

    public function showCategory($category)
    {
        $products = Product::where('category', $category)->get();

        return view('end_user.product.showAll', compact('products', 'category'));
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('end_user.product.show', compact('product'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:Malay,Chinese,Indian',
            'price' => 'required|numeric|min:0',
            'colors' => 'required|array',
            'colors.*' => 'array',
            'colors.*.sizes' => 'required|array',
            'colors.*.sizes.*.quantity' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::create(array_merge(
            $validatedData,
            ['stock_quantity' => (new Product)->calculateStockQuantity($validatedData['colors'])]
        ));

        $product->addColorsAndSizes($validatedData['colors']);

        if ($request->hasFile('images')) {
            $product->storeImages($request->file('images'));
        }

        return redirect()->route('admin.product.index');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:Malay,Chinese,Indian,Other',
            'price' => 'required|numeric',
            'colors' => 'required|array',
            'colors.*' => 'array',
            'colors.*.sizes' => 'required|array',
            'colors.*.sizes.*.quantity' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->update(
            array_merge(
                $validatedData,
                ['stock_quantity' => (new Product)->calculateStockQuantity($validatedData['colors'])]
            )
        );

        $product->updateColorsAndSizes($validatedData['colors']);

        if ($request->hasFile('images')) {
            $product->deleteImages();
            $images = $request->file('images');
            foreach ($images as $image) {
                ProductImage::storeImage($image, $product);
            }
        }

        return redirect()->route('admin.product.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $product->delete();

        return redirect()->route('admin.product.index');
    }
}
