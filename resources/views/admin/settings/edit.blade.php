@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Website Settings</h2>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        {!! '<!-- Branding & SEO -->' !!}
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-palette me-2"></i>Branding & Details</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Website Name</label>
                        <input type="text" name="website_name" class="form-control @error('website_name') is-invalid @enderror" value="{{ old('website_name', $settings->website_name) }}">
                        @error('website_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Site Logo (Recommended: PNG with transparent bg)</label>
                            @if($settings->logo)
                                <div class="mb-2 p-2 border rounded d-inline-block bg-light">
                                    <img src="{{ Storage::url('settings/' . $settings->logo) }}" alt="Logo" style="max-height: 60px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Favicon (Recommended: 32x32 ICO or PNG)</label>
                            @if($settings->favicon)
                                <div class="mb-2 p-2 border rounded d-inline-block bg-light">
                                    <img src="{{ Storage::url('settings/' . $settings->favicon) }}" alt="Favicon" style="max-height: 32px;">
                                </div>
                            @endif
                            <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" accept="image/*">
                            @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!! '<!-- Contact Information -->' !!}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-telephone me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings->email) }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">GST Number</label>
                        <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" value="{{ old('gst_number', $settings->gst_number) }}">
                        @error('gst_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Store Address</label>
                        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $settings->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {!! '<!-- Social & Footer -->' !!}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-share me-2"></i>Social & Footer</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" value="{{ old('facebook_url', $settings->facebook_url) }}">
                        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Twitter/X URL</label>
                        <input type="url" name="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" value="{{ old('twitter_url', $settings->twitter_url) }}">
                        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $settings->instagram_url) }}">
                        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Footer Text (About Store)</label>
                        <textarea name="footer_text" rows="3" class="form-control @error('footer_text') is-invalid @enderror">{{ old('footer_text', $settings->footer_text) }}</textarea>
                        @error('footer_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {!! '<!-- SEO Settings -->' !!}
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-search me-2"></i>SEO & Social Media Meta</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Global Meta Title</label>
                            <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $settings->meta_title) }}">
                            <small class="text-muted">Overrides website name in title if set.</small>
                            @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Global Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', $settings->meta_keywords) }}">
                            <small class="text-muted">Comma separated (e.g. fireworks, sivakasi crackers, diwali)</small>
                            @error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Global Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $settings->meta_description) }}</textarea>
                            @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Open Graph Image (Social Media Preview)</label>
                            @if($settings->og_image)
                                <div class="mb-2 p-2 border rounded d-inline-block bg-light w-100">
                                    <img src="{{ Storage::url('settings/' . $settings->og_image) }}" alt="OG Image" style="max-height: 100px; max-width: 100%;">
                                </div>
                            @endif
                            <input type="file" name="og_image" class="form-control @error('og_image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Recommended: 1200x630 pixels</small>
                            @error('og_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-end mb-5">
        <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-bold">
            <i class="bi bi-save me-2"></i> Save Settings
        </button>
    </div>
</form>
@endsection
