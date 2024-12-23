@extends('structures.main')

@section('content')
    <div class="container-fluid mb-5">
        <h1 class="fw-bold text-center my-4">Themes</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @if (Auth::user()->hasPermission('Install Themes Tab'))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="installed-themes-tab" data-bs-toggle="tab" href="#installed-themes"
                            role="tab" aria-controls="installed-themes" aria-selected="true">Installed Themes</a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Themes List Tab'))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="wp-themes-list-tab" data-bs-toggle="tab" href="#wp-themes-list"
                            role="tab" aria-controls="wp-themes-list" aria-selected="false">WP Themes List</a>
                    </li>
                @endif
            </ul>
            @if (Auth::user()->hasPermission('Upload Themes'))
                <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal"
                    data-bs-target="#themesModal">
                    <i class="bi bi-cloud-arrow-up"></i> Upload Themes
                </button>
            @endif
        </div>

        <div class="tab-content" id="myTabContent">

            <!-- Installed Themes Tab -->
            <div class="tab-pane fade show active" id="installed-themes" role="tabpanel"
                aria-labelledby="installed-themes-tab">
                <div class="card shadow-sm border-light rounded w-100">
                    <div class="card-header bg-primary text-white table_headercolor">
                        <h5 class="mb-0 ">Installed Themes</h5>
                    </div>
                    <div class="card-body p-4">
                        <table id="installedthemessTable" class="table table-striped text-center rounded">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- WP Themes List Tab -->
            <div class="tab-pane fade" id="wp-themes-list" role="tabpanel" aria-labelledby="wp-themes-list-tab">
                <div class="card shadow-sm border-light rounded w-100">
                    <div class="card-header text-white table_headercolor">
                        <h5 class="mb-0">WP Themes List</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">

                            <!-- Search Form (only visible if the user has the permission) -->
                            @if (Auth::user()->hasPermission('Themes Search'))
                                <form id="searchForm" method="get" class="form-group d-flex align-items-center ms-auto">
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Search for themes...">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <table id="themesTable" class="table table-striped text-center rounded" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <!-- Loader Modal -->
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


    <!-- Modal -->
    <div class="modal fade" id="themesModal" tabindex="-1" aria-labelledby="themesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/uploadthemes" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="themesModalLabel">Upload Themes's</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label"> Theme Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
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
                            <label for="file_path" class="form-label">Upload Themes</label>
                            <input type="file" class="form-control @error('name') is-invalid @enderror" id="file_path"
                                name="file_path" value="{{ old('file_path') }}">
                            @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="themesCategoryupload" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                id="themesCategoryupload" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Category Selection Modal -->
    <div class="modal fade" id="categorySelectionModal" tabindex="-1" aria-labelledby="categorySelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categorySelectionModalLabel">Select Category for Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Category selection dropdown -->
                    <select class="form-select" id="themesCategory" required>
                        <option value="" disabled selected>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <!-- Hidden inputs to store theme data -->
                    <input type="hidden" id="themeSlug" />
                    <input type="hidden" id="themeName" />
                    <input type="hidden" id="themeDescription" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmDownload">Download</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Loader Modal -->
    <div class="modal fade" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        const readMoreButton = document.querySelector('.read-more');
        const shortDescription = document.querySelector('.short-description');
        const fullDescription = document.querySelector('.full-description');

        // Check if the elements exist before adding the event listener
        if (readMoreButton && shortDescription && fullDescription) {
            readMoreButton.addEventListener('click', function() {
                shortDescription.style.display = 'none';
                fullDescription.style.display = 'block';
            });
        }
    </script>





    <script>
        const hasDownloadPermission = @json(Auth::user()->hasPermission('Download Themes'));
    </script>


    {{-- //script --}}
    <script src="assets/js/themes.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 0;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .card {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
            width: 100%;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 2px solid #87CEEB;
            padding: 12px;
        }

        table th {
            background-color: #87CEEB;
            color: #000;
        }

        .input-group {
            position: relative;
            top: 1em;
        }
    </style>
@endsection
