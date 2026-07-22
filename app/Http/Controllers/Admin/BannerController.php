<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\Admin\BannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(BannerRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
