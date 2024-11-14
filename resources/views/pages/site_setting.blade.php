@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center">Site Settings</h1>
    </div>

    {{-- CARD DIV --}}
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Site Settings</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('site.settings.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="site_title" class="form-label">Site Title</label>
                            <input type="text" id="site_title" name="site_title" class="form-control"
                                value="{{ old('site_title', $siteSetting->site_title ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Logo Image</label>
                            <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                            @if ($siteSetting && $siteSetting->logo)
                                <div class="mt-2 text-center" style="background-color: #90EE90;">
                                    <p>Current Logo: {{ basename($siteSetting->logo) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="header_background" class="form-label">Header Background Color</label>
                            <input type="color" id="header_background" name="header_background" class="form-control"
                                value="{{ old('header_background', $siteSetting->header_background ?? '#ffffff') }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="header_text" class="form-label">Header Text Color</label>
                            <input type="color" id="header_text" name="header_text" class="form-control"
                                value="{{ old('header_text', $siteSetting->header_text ?? '#000000') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="footer_text" class="form-label">Footer Text Color</label>
                            <input type="color" id="footer_text" name="footer_text" class="form-control"
                                value="{{ old('footer_text', $siteSetting->footer_text ?? '#000000') }}" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="footer_background" class="form-label">Footer Background Color</label>
                            <input type="color" id="footer_background" name="footer_background" class="form-control"
                                value="{{ old('footer_background', $siteSetting->footer_background ?? '#ffffff') }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="header_btncolor" class="form-label">Header Button Color</label>
                            <input type="color" id="header_btncolor" name="header_btncolor" class="form-control"
                                value="{{ old('header_btncolor', $siteSetting->header_btncolor ?? '#000000') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="header_btn_bgcolor" class="form-label">Header Button Background Color</label>
                            <input type="color" id="header_btn_bgcolor" name="header_btn_bgcolor" class="form-control"
                                value="{{ old('header_btn_bgcolor', $siteSetting->header_btn_bgcolor ?? '#ffffff') }}"
                                required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
