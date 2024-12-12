@extends('structures.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 ">Coupon Management</h1>
    </div>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    timerProgressBar: true,
                    showCloseButton: true,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reload the DataTable after the success message
                    coupontable.ajax.reload();
                });
            });
        </script>
    @endif

    <div class="container ">
        <div class="card">
            <div class="card-body">
                <div class="form-container mt-5">
                    <form action="{{ route('create.coupon') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount" class="form-label">Discount Percentage:</label>
                                <input type="number" name="discount" id="discount" class="form-control" required
                                    min="1">
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Coupon Name:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">Coupon Code:</label>
                                <input type="text" name="code" id="code" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="duration" class="form-label">Duration:</label>
                                <select name="duration" id="duration" class="form-select" required>
                                    <option value="once">Once</option>
                                    <option value="forever">Forever</option>
                                    <option value="repeating">Repeating</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="duration_in_months" class="form-label">Duration in Months (for
                                    Repeating):</label>
                                <input type="number" name="duration_in_months" id="duration_in_months" class="form-control"
                                    min="1" disabled>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Coupon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="card m-4">
        <div class="card-header table_headercolor text-white">
            <h5 class="mb-0">Coupon Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-5">
                <div id="couponcontainer" class="dataTables_wrapper no-footer mt-2">
                    <table id="coupontable" class="display table table-bordered">
                        <thead class="custom-thead">
                            <tr>
                                <th>SR.NO</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Percent off / Discount Percentage:</th>
                                <th>Duration</th>
                                <th>Duration in Months</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTable AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('duration').addEventListener('change', function() {
            var durationInMonthsField = document.getElementById('duration_in_months');
            if (this.value === 'repeating') {
                durationInMonthsField.disabled = false;
            } else {
                durationInMonthsField.disabled = true;
            }
        });


        $(document).ready(function() {
            coupontable = $('#coupontable').DataTable({
                ajax: {
                    url: '/getCoupon',
                    type: 'GET',
                    dataSrc: "data"
                },
                columns: [{
                        data: null,
                        title: 'SR.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'percent_off',
                        name: 'percent_off'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'duration_in_months',
                        name: 'duration_in_months',
                        render: function(data, type, row) {
                            // If 'duration_in_months' is null, show "Once" or "Forever" based on 'duration'
                            if (data === null) {
                                return row.duration === 'once' ? 'Once' : (row.duration ===
                                    'forever' ? 'Forever' : 'N/A');
                            }
                            return data;
                        }
                    }

                ],
            });
        });
    </script>
@endsection
