<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Create Supply Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-size: 0.9rem !important;
        }

        .card-custom {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            max-width: 800px;
            margin: 0.3rem auto;
        }

        h1 {
            text-align: center;
            color: #0A28D8;
            margin-bottom: 2rem;
            font-weight: 900 !important;
        }

        .card-custom p {
            margin-bottom: 4rem;
        }

        .card-custom h1 {
            margin-bottom: 1rem;
        }


        .icon-register {
            height: 50px !important;
            width: 50px !important;
            display: block;
            margin: 1rem auto;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    @extends('office-layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')

    <div class="card-custom">
        <h1 class="mb-4">Supply Request</h1>
        <p>Fill out the form below to request supplies. The Supply Office will review your request and decide on the issuance based on availability and need.</p>

        <form method="POST" action="{{ route('request.store') }}" class="bg-white "
            id="requestForm">
            @csrf

           <div class="mb-3">
                <label for="office" class="form-label">Office</label>
                <input type="text" id="office" name="office" class="form-control" required value="{{ old('office', auth()->check() ? auth()->user()->office : '') }}" />
            </div>

            <div class="mb-3">
                <label for="request_by" class="form-label">Requested by</label>
                <input type="text" id="request_by" name="request_by" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="request_by_designation" class="form-label">Designation</label>
                <input type="text" id="request_by_designation" name="request_by_designation" class="form-control"
                    required />
            </div>

            <div class="table-responsive mb-3">
                <label for="office" class="form-label">Requisition</label>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Available</th>
                            <th scope="col">Request Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplies as $supply)
                        <tr>
                            <td>
                                <input type="hidden" name="items[{{ $loop->index }}][supply_id]"
                                    value="{{ $supply->id }}" />
                                {{ $supply->item }}
                            </td>
                             <td>
                                {{ $supply->description }}
                            </td>
                            <td>{{ $supply->quantity }}</td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][quantity]" min="0"
                                    max="{{ $supply->quantity }}" value="0" class="form-control"
                                    aria-label="Request quantity for {{ $supply->item }}" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="quantityError" class="alert alert-danger d-none">Please request at least one item.</div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Cancel Request</a>
        </form>
    </div>

    <script>
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            let hasQuantity = false;
            document.querySelectorAll('input[type="number"][name^="items"]').forEach(function(input) {
                if (parseInt(input.value, 10) > 0) {
                    hasQuantity = true;
                } else {
                    input.disabled = true;
                    let hidden = input.closest('tr').querySelector('input[type="hidden"]');
                    if (hidden) hidden.disabled = true;
                }
            });
            if (!hasQuantity) {
                e.preventDefault();
                document.getElementById('quantityError').classList.remove('d-none');
            }
        });
    </script>

    @endsection
</body>

</html>