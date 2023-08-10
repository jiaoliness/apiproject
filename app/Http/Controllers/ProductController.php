<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\{ProductResource,ProductCollection};
use App\Models\{Product,ProductImage};

class ProductController extends Controller
{
    /**
     * Display all products
     */
    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Create a new product
     */
    public function store(Request $request)
    {
        
        $product = Product::create([
          'name' => $request->name,
          'details' => $request->details,
        ]);

        return new ProductResource($product);
    }

    /**
     * Display a specfici product
     */
    public function show(int $id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    /**
     * Update a product
     */
    public function update(Request $request, int $id)
    {

      $validated = $request->validate([
          'name' =>  ['required', 'max:255'],
          'details' => ['required'],
      ]);

      $product = Product::find($id);

      $product->update($validated);

      return new ProductResource($product);
    }

    /**
     * Delete a product
     */
    public function destroy(int $id)
    {
        Product::find($id)->delete();
        return 'Product deleted';
    }

    /**
     * Create a new image entry that belongs to the product
     */
    public function addImage(Request $request, int $id)
    {
        ProductImage::create([
          'product_id' => $id,
          'filename' => $request->filename
        ]);

        return "Product Image added";
    }


}
