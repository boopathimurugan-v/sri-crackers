<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockEntryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name', 'asc')->get();
        $stockHistories = StockHistory::with('product')->latest()->paginate(15);

        return view('admin.stock_entries.index', compact('products', 'stockHistories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'added_quantity' => 'required|integer|not_in:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        $previousStock = (int) $product->stock;
        $addedQuantity = (int) $request->added_quantity;
        $newStock = max(0, $previousStock + $addedQuantity);

        // Update product stock
        $product->update([
            'stock' => $newStock,
            'is_available' => $newStock > 0 ? 1 : 0
        ]);

        // Record stock history audit trail
        StockHistory::create([
            'product_id' => $product->id,
            'previous_stock' => $previousStock,
            'added_quantity' => $addedQuantity,
            'new_stock' => $newStock,
            'remarks' => $request->remarks ?? 'Manual Stock Entry',
            'updated_by' => Auth::user() ? Auth::user()->name : 'Admin',
        ]);

        return redirect()->route('admin.stock-entries.index')->with('success', "Stock updated successfully for {$product->name}. New Stock: {$newStock}");
    }
}
