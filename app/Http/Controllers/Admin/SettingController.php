<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first() ?? new Setting();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'gst_number' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'footer_text' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::disk('public')->delete('settings/' . $settings->logo);
            }
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->storeAs('settings', $logoName, 'public');
            $validated['logo'] = $logoName;
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon) {
                Storage::disk('public')->delete('settings/' . $settings->favicon);
            }
            $favicon = $request->file('favicon');
            $faviconName = time() . '_favicon.' . $favicon->getClientOriginalExtension();
            $favicon->storeAs('settings', $faviconName, 'public');
            $validated['favicon'] = $faviconName;
        }

        if ($request->hasFile('og_image')) {
            if ($settings->og_image) {
                Storage::disk('public')->delete('settings/' . $settings->og_image);
            }
            $ogImage = $request->file('og_image');
            $ogImageName = time() . '_og.' . $ogImage->getClientOriginalExtension();
            $ogImage->storeAs('settings', $ogImageName, 'public');
            $validated['og_image'] = $ogImageName;
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }
}
