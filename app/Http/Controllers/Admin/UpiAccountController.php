<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UpiAccount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpiAccountController extends Controller
{
    public function index()
    {
        $upiAccounts = UpiAccount::withCount('orders')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $todayOrders = Order::whereDate('created_at', Carbon::today())->latest()->take(10)->get();
        $totalTodayCollection = UpiAccount::sum('current_collection');

        return view('admin.upi.index', compact('upiAccounts', 'todayOrders', 'totalTodayCollection'));
    }

    public function create()
    {
        return view('admin.upi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'upi_id' => 'required|string|max:255',
            'daily_limit' => 'required|numeric|min:0',
            'display_order' => 'nullable|integer',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'account_holder_name', 'upi_id', 'daily_limit', 'display_order']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['current_collection'] = 0.00;

        if ($request->hasFile('qr_image')) {
            $data['qr_image'] = $request->file('qr_image')->store('upi_qr', 'public');
        }

        UpiAccount::create($data);

        return redirect()->route('admin.upi.index')->with('success', 'UPI Account added successfully.');
    }

    public function edit(UpiAccount $upi)
    {
        return view('admin.upi.edit', compact('upi'));
    }

    public function update(Request $request, UpiAccount $upi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'upi_id' => 'required|string|max:255',
            'daily_limit' => 'required|numeric|min:0',
            'display_order' => 'nullable|integer',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'account_holder_name', 'upi_id', 'daily_limit', 'display_order']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('qr_image')) {
            if ($upi->qr_image && Storage::disk('public')->exists($upi->qr_image)) {
                Storage::disk('public')->delete($upi->qr_image);
            }
            $data['qr_image'] = $request->file('qr_image')->store('upi_qr', 'public');
        }

        $upi->update($data);

        return redirect()->route('admin.upi.index')->with('success', 'UPI Account updated successfully.');
    }

    public function destroy(UpiAccount $upi)
    {
        if ($upi->qr_image && Storage::disk('public')->exists($upi->qr_image)) {
            Storage::disk('public')->delete($upi->qr_image);
        }

        $upi->delete();

        return redirect()->route('admin.upi.index')->with('success', 'UPI Account deleted successfully.');
    }

    public function toggleStatus(UpiAccount $upi)
    {
        $upi->update(['is_active' => !$upi->is_active]);

        return redirect()->back()->with('success', 'UPI Account status updated successfully.');
    }

    public function resetCollection(UpiAccount $upi)
    {
        $upi->resetCollection();

        return redirect()->back()->with('success', "Collection reset to ₹0 for {$upi->name}.");
    }

    public function resetAllCollections()
    {
        UpiAccount::query()->update(['current_collection' => 0.00]);

        return redirect()->back()->with('success', "Today's collection reset to ₹0 for all UPI Accounts.");
    }
}
