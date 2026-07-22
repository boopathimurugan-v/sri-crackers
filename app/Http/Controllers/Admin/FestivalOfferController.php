<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FestivalOffer;
use App\Http\Requests\Admin\FestivalOfferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FestivalOfferController extends Controller
{
    public function index()
    {
        $offers = FestivalOffer::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.festival_offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.festival_offers.create');
    }

    public function store(FestivalOfferRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('festival_offers', 'public');
        }

        FestivalOffer::create($data);

        return redirect()->route('admin.festival-offers.index')->with('success', 'Festival offer created successfully.');
    }

    public function edit(FestivalOffer $festivalOffer)
    {
        return view('admin.festival_offers.edit', compact('festivalOffer'));
    }

    public function update(FestivalOfferRequest $request, FestivalOffer $festivalOffer)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($festivalOffer->image) {
                Storage::disk('public')->delete($festivalOffer->image);
            }
            $data['image'] = $request->file('image')->store('festival_offers', 'public');
        }

        $festivalOffer->update($data);

        return redirect()->route('admin.festival-offers.index')->with('success', 'Festival offer updated successfully.');
    }

    public function destroy(FestivalOffer $festivalOffer)
    {
        if ($festivalOffer->image) {
            Storage::disk('public')->delete($festivalOffer->image);
        }
        $festivalOffer->delete();

        return redirect()->route('admin.festival-offers.index')->with('success', 'Festival offer deleted successfully.');
    }
}
