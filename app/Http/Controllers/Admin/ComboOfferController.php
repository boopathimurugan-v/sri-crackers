<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComboOffer;
use App\Http\Requests\Admin\ComboOfferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComboOfferController extends Controller
{
    public function index()
    {
        $offers = ComboOffer::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.combo_offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.combo_offers.create');
    }

    public function store(ComboOfferRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('combo_offers', 'public');
        }

        ComboOffer::create($data);

        return redirect()->route('admin.combo-offers.index')->with('success', 'Combo offer created successfully.');
    }

    public function edit(ComboOffer $comboOffer)
    {
        return view('admin.combo_offers.edit', compact('comboOffer'));
    }

    public function update(ComboOfferRequest $request, ComboOffer $comboOffer)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($comboOffer->image) {
                Storage::disk('public')->delete($comboOffer->image);
            }
            $data['image'] = $request->file('image')->store('combo_offers', 'public');
        }

        $comboOffer->update($data);

        return redirect()->route('admin.combo-offers.index')->with('success', 'Combo offer updated successfully.');
    }

    public function destroy(ComboOffer $comboOffer)
    {
        if ($comboOffer->image) {
            Storage::disk('public')->delete($comboOffer->image);
        }
        $comboOffer->delete();

        return redirect()->route('admin.combo-offers.index')->with('success', 'Combo offer deleted successfully.');
    }
}
