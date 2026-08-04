<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false)->withCount('orders')->withSum('orders as total_spent', 'total_amount');

        // Search by Name, Mobile, Email
        if ($request->filled('search')) {
            $search = trim($request->get('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Filters: Active, New, Repeat, High Value
        if ($request->filled('filter')) {
            switch ($request->get('filter')) {
                case 'active':
                    $query->where('is_blocked', false);
                    break;
                case 'blocked':
                    $query->where('is_blocked', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', Carbon::now()->subDays(30));
                    break;
                case 'repeat':
                    $query->has('orders', '>', 1);
                    break;
                case 'high_value':
                    $query->having('total_spent', '>=', 5000);
                    break;
            }
        }

        $customers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->load(['addresses', 'orders' => function ($q) {
            $q->latest();
        }]);

        $totalSpent = $customer->orders->sum('total_amount');
        $ordersCount = $customer->orders->count();

        return view('admin.customers.show', compact('customer', 'totalSpent', 'ordersCount'));
    }

    public function edit(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'is_blocked' => 'nullable|boolean',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_blocked' => $request->has('is_blocked') ? 1 : 0,
            'status' => $request->has('is_blocked') ? 'blocked' : 'active',
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer profile updated successfully.');
    }

    public function toggleBlock(User $customer)
    {
        if ($customer->is_admin) {
            abort(403);
        }

        $newStatus = !$customer->is_blocked;
        $customer->update([
            'is_blocked' => $newStatus,
            'status' => $newStatus ? 'blocked' : 'active',
        ]);

        $msg = $newStatus ? 'Customer blocked successfully.' : 'Customer unblocked successfully.';
        return redirect()->back()->with('success', $msg);
    }

    public function destroy(User $customer)
    {
        if ($customer->is_admin) {
            abort(403);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
