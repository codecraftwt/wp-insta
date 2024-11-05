@extends('structures.main')

@section('content')
    <div class="container-fluid mb-5">
        <h1 class="fw-bold text-center my-4">Version</h1>

        <div class="d-flex justify-content-between mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#versionsModal"
                id="wp-version">
                <i class="bi bi-folder-plus"></i> ADD Version
            </button>
        </div>

        <div class="modal fade" id="versionsModal" tabindex="-1" aria-labelledby="versionsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="versionsModalLabel">Add WordPress Version</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('version_store') }}" method="POST">
                            @csrf <!-- Laravel CSRF protection -->
                            <div class="mb-4">
                                <label for="name" class="form-label">Select Version</label>

                                <select class="form-select @error('name') is-invalid @enderror" id="name"
                                    name="name" @readonly(true)>

                                    <option value="6.2.2" selected> WordPress 6.2.2</option>
                                    <option value="6.3"> WordPress 6.3</option>
                                    <option value="6.3.1"> WordPress 6.3.1</option>
                                    <option value="6.2"> WordPress 6.2</option>
                                    <option value="6.1"> WordPress 6.1</option>
                                    <option value="6.0"> WordPress 6.0</option>
                                    <option value="5.9"> WordPress 5.9</option>
                                    <option value="5.8"> WordPress 5.8</option>
                                    <option value="5.7"> WordPress 5.7</option>
                                    <option value="5.6"> WordPress 5.6</option>
                                    <option value="5.5"> WordPress 5.5</option>
                                    <option value="5.4"> WordPress 5.4</option>
                                    <option value="5.3"> WordPress 5.3</option>
                                    <option value="5.2"> WordPress 5.2</option>
                                    <option value="5.1"> WordPress 5.1</option>
                                    <option value="5.0"> WordPress 5.0</option>
                                    <option value="4.9"> WordPress 4.9</option>
                                    <option value="4.8"> WordPress 4.8</option>
                                    <option value="4.7"> WordPress 4.7</option>
                                    <option value="4.6"> WordPress 4.6</option>
                                    <option value="4.5"> WordPress 4.5</option>
                                    <option value="4.4"> WordPress 4.4</option>
                                    <option value="4.3"> WordPress 4.3</option>
                                    <option value="4.2"> WordPress 4.2</option>
                                    <option value="4.1"> WordPress 4.1</option>
                                    <option value="4.0"> WordPress 4.0</option>
                                    <option value="3.9"> WordPress 3.9</option>
                                    <option value="3.8"> WordPress 3.8</option>
                                    <option value="3.7"> WordPress 3.7</option>
                                    <option value="3.6"> WordPress 3.6</option>
                                    <option value="3.5"> WordPress 3.5</option>
                                    <option value="3.4"> WordPress 3.4</option>
                                    <option value="3.3"> WordPress 3.3</option>
                                    <option value="3.2"> WordPress 3.2</option>
                                    <option value="3.1"> WordPress 3.1</option>
                                    <option value="3.0"> WordPress 3.0</option>
                                    <option value="2.9"> WordPress 2.9</option>
                                    <option value="2.8"> WordPress 2.8</option>
                                    <option value="2.7"> WordPress 2.7</option>
                                    <option value="2.6"> WordPress 2.6</option>
                                    <option value="2.5"> WordPress 2.5</option>
                                    <option value="2.3"> WordPress 2.3</option>
                                    <option value="2.2"> WordPress 2.2</option>
                                    <option value="2.1"> WordPress 2.1</option>
                                    <option value="2.0"> WordPress 2.0</option>
                                    <option value="1.5"> WordPress 1.5</option>
                                    <option value="1.2"> WordPress 1.2</option>
                                    <option value="1.0"> WordPress 1.0</option>
                                </select>

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

                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class=" mt-5">
            <div class="card">

                <div class="card-body p-4">
                    <table id="versiontalbe" class="table table-striped text-center rounded" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Type</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/wp-version.js"></script>

    <script>
        $(document).ready(function() {
            $('#name').select2({
                dropdownParent: $('#versionsModal'),
                placeholder: "Select an Option",
                allowClear: true
            });

        });
    </script>
    <style>
        body {
            background-color: #f8f9fa;
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

        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 8px;
            padding-right: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 20vw !important;
        }
    </style>
@endsection
