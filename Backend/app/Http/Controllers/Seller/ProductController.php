<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
        }

        $product = Product::create([
            'seller_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image_path' => $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null,
            'gallery' => json_encode($galleryPaths),
            'weight' => $validated['weight'] ?? null,
            'attributes' => $validated['attributes'] ? json_encode($validated['attributes']) : null,
            'is_active' => $validated['is_active'],
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\ProductResource($product),
            'Product created successfully.',
            201
        );
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image_path);
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $existingGallery = json_decode($product->gallery, true) ?: [];
            foreach ($existingGallery as $path) {
                Storage::disk('public')->delete($path);
            }

            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
            $product->gallery = json_encode($galleryPaths);
        }

        $product->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'weight' => $validated['weight'] ?? null,
            'attributes' => $validated['attributes'] ? json_encode($validated['attributes']) : null,
            'is_active' => $validated['is_active'],
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\ProductResource($product),
            'Product updated successfully.',
            200
        );
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return new \App\Http\Resources\ApiResponseResource(null, 'Product deleted successfully.', 200);
    }
}
