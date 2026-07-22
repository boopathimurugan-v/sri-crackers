<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'type' => 'required|string|in:home,work,other',
        ]);

        $is_default = $request->has('is_default');
        
        if ($is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create(array_merge(
            $request->except('is_default'),
            ['is_default' => $is_default]
        ));

        return redirect()->route('customer.addresses.index')->with('success', 'Address added successfully.');
    }

    public function edit(Address $address)
    {
        $this->authorizeAddress($address);
        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $this->authorizeAddress($address);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'type' => 'required|string|in:home,work,other',
        ]);

        $is_default = $request->has('is_default');
        
        if ($is_default) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update(array_merge(
            $request->except('is_default'),
            ['is_default' => $is_default]
        ));

        return redirect()->route('customer.addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        $this->authorizeAddress($address);
        $address->delete();
        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted successfully.');
    }

    private function authorizeAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
