<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->get();
        return view('customer.wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth()->user();
        
        $exists = $user->wishlists()->where('product_id', $request->product_id)->exists();
        
        if (!$exists) {
            $user->wishlists()->create(['product_id' => $request->product_id]);
            return back()->with('success', 'Product added to wishlist.');
        }

        return back()->with('info', 'Product is already in your wishlist.');
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }
        
        $wishlist->delete();
        return back()->with('success', 'Product removed from wishlist.');
    }
}
