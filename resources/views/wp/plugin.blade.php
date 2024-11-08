@extends('structures.main')

@section('content')
    <div class="container-fluid mb-5"> <!-- Changed to container-fluid -->
        <h1 class="fw-bold text-center my-4">Plugins</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="installed-plugin-tab" data-bs-toggle="tab" href="#installed-plugin"
                        role="tab" aria-controls="installed-plugin" aria-selected="true">Installed Plugins</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="wp-plugin-list-tab" data-bs-toggle="tab" href="#wp-plugin-list" role="tab"
                        aria-controls="wp-plugin-list" aria-selected="false">WP Plugin List</a>
                </li>
            </ul>
            <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#pluginModal">
                <i class="bi bi-cloud-arrow-up"></i> Upload Plugin
            </button>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="pluginModal" tabindex="-1" aria-labelledby="pluginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('uploadPlugin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="pluginModalLabel">Upload Plugin's</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label"> Plugins Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file_path" class="form-label">Upload Plugins</label>
                                <input type="file" class="form-control @error('name') is-invalid @enderror"
                                    id="file_path" name="file_path" value="{{ old('file_path') }}">
                                @error('file_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pluginCategory" class="form-label">Plugin Category</label>
                                <select class="form-select" id="pluginCategory" name="category_id" required>
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary m-2">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="installed-plugin" role="tabpanel"
                aria-labelledby="installed-plugin-tab">
                <div class="card shadow-sm border-light rounded w-100">
                    <div class="card-body">
                        <h5 class="card-title text-center">Installed Plugins</h5>
                        <table id="installedPluginsTable" class="table table-striped text-center rounded">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="wp-plugin-list" role="tabpanel" aria-labelledby="wp-plugin-list-tab">
                <div class="card shadow-sm border-light rounded w-100">
                    <div class="card-header">
                        <h5 class="mb-0 text-center">WP Plugin List</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="input-group me-1">

                            </div>
                            <form id="searchForm" method="get" class="d-flex">
                                <input type="text" class="form-control me-12" id="searchInput"
                                    placeholder="Search for plugins...">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                        </div>
                        <table id="wpPluginsTable" class="table table-striped text-center rounded" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for downloading the plugin -->
    {{-- <div class="modal fade" id="downloadPluginModal" tabindex="-1" aria-labelledby="downloadPluginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadPluginModalLabel">Download Plugin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="downloadPluginForm">
                        <div class="mb-3">
                            <label for="pluginName" class="form-label">Plugin Name</label>
                            <input type="text" class="form-control" id="pluginName" required>
                        </div>
                        <div class="mb-3">
                            <button type="button" id="downloadBtn" class="btn btn-success">Download Plugin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="downloadPluginModal" tabindex="-1" aria-labelledby="downloadPluginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadPluginModalLabel">Download Plugin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="downloadPluginForm">
                        <input type="hidden" id="pluginSlug"> <!-- Hidden field for slug -->
                        <input type="hidden" id="shortDescription"> <!-- Hidden field for short description -->
                        <div class="mb-3">
                            <label for="pluginCategory" class="form-label">Plugin Category</label>
                            <select class="form-select" id="pluginCategory" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="button" id="downloadBtn" class="btn btn-success">Download Plugin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Downloading theme, please wait...</p>
                </div>
            </div>
        </div>
    </div>








    <script src="assets/js/plugin.js"></script>

    <style>
        /* Custom styles for a more attractive layout */
        body {
            background-color: #f8f9fa;
            /* Light background for better contrast */
        }

        .nav-tabs .nav-link {
            border: none;
            /* Remove borders for a cleaner look */
            border-radius: 0;
            /* Remove rounded corners */
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            /* Primary color for active tab */
            color: #fff;
            /* White text for active tab */
        }

        .card {
            border-radius: 0.5rem;
            /* Slightly rounded corners for cards */
            border: 1px solid #dee2e6;
            /* Light border for card */
            margin-bottom: 1rem;
            /* Space below the card */
            width: 100%;
            /* Full width of parent container */
        }

        table {
            border-collapse: collapse;
            /* Ensure borders collapse properly */
            margin-top: 20px;
            /* Space between table and other elements */
        }

        table th,
        table td {
            border: 2px solid #87CEEB;
            /* Sky blue border */
            padding: 12px;
            /* Padding for cells */
        }

        table th {
            background-color: #87CEEB;
            /* Header background color */
            color: #fff;
            /* Header text color */
        }

        table td {
            background-color: #E0F7FA;
            /* Light blue background for table rows */
            vertical-align: middle;
            /* Center table cell content */
        }

        #uploadButton {
            align-self: flex-end;
            /* Align the upload button to the top right */
        }
    </style>
@endsection
