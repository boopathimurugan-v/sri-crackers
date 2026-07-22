<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter: Deleted
        if ($request->has('filter') && $request->filter == 'deleted') {
            $query->onlyTrashed();
        } else {
            // Only apply other filters if we aren't specifically looking for only trashed items
            
            if ($request->has('search') && $request->search != '') {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('sku', 'like', '%' . $search . '%');
                });
            }
    
            if ($request->has('category_id') && $request->category_id != '') {
                $query->where('category_id', $request->category_id);
            }
            
            if ($request->has('filter') && $request->filter != '') {
                switch ($request->filter) {
                    case 'available':
                        $query->where('is_available', 1);
                        break;
                    case 'unavailable':
                        $query->where('is_available', 0);
                        break;
                    case 'featured':
                        $query->where('featured', 1);
                        break;
                    case 'trending':
                        $query->where('trending', 1);
                        break;
                    case 'low_stock':
                        $query->where('stock', '>', 0)->where('stock', '<=', 10);
                        break;
                    case 'out_of_stock':
                        $query->where('stock', 0);
                        break;
                }
            }
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $products = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['trending'] = $request->has('trending') ? 1 : 0;
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        // Ensure slug is unique, might append random if exists
        $count = Product::withTrashed()->where('slug', $data['slug'])->count();
        if($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product = Product::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category', 'images');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['trending'] = $request->has('trending') ? 1 : 0;
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        $count = Product::withTrashed()->where('slug', $data['slug'])->where('id', '!=', $product->id)->count();
        if($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product soft deleted successfully.');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        
        return redirect()->back()->with('success', 'Product restored successfully.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        
        foreach($product->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $product->forceDelete();
        
        return redirect()->back()->with('success', 'Product permanently deleted.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
        return redirect()->back()->with('success', 'Product status updated successfully.');
    }

    public function toggleAvailability(Product $product)
    {
        $product->update(['is_available' => !$product->is_available]);
        return redirect()->back()->with('success', 'Product availability updated successfully.');
    }
    
    public function deleteGalleryImage(ProductImage $image)
    {
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        
        return redirect()->back()->with('success', 'Gallery image deleted successfully.');
    }
}
