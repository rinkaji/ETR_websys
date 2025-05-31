<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Create Supply Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Create Supply Request</h1>

        <form method="POST" action="{{ route('request.store') }}" class="bg-white p-4 rounded shadow-sm" id="requestForm">
            @csrf

            <div class="mb-3">
                <label for="office" class="form-label">Office:</label>
                <input type="text" id="office" name="office" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="request_by" class="form-label">Requested By:</label>
                <input type="text" id="request_by" name="request_by" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="request_by_designation" class="form-label">Designation:</label>
                <input type="text" id="request_by_designation" name="request_by_designation" class="form-control" required />
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Supply</th>
                            <th scope="col">Available</th>
                            <th scope="col">Request Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplies as $supply)
                        <tr>
                            <td>
                                <input type="hidden" name="items[{{ $loop->index }}][supply_id]" value="{{ $supply->id }}" />
                                {{ $supply->item }}
                            </td>
                            <td>{{ $supply->quantity }}</td>
                            <td>
                                <input
                                    type="number"
                                    name="items[{{ $loop->index }}][quantity]"
                                    min="0"
                                    max="{{ $supply->quantity }}"
                                    value="0"
                                    class="form-control"
                                    aria-label="Request quantity for {{ $supply->item }}" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="quantityError" class="alert alert-danger d-none">Please request at least one item.</div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Back to Dashboard</a>
        </form>
    </div>
    <script>
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            let hasQuantity = false;
            // Remove zero-quantity items before submit
            document.querySelectorAll('input[type="number"][name^="items"]').forEach(function(input) {
                if (parseInt(input.value, 10) > 0) {
                    hasQuantity = true;
                } else {
                    // Disable zero-quantity fields so they are not submitted
                    input.disabled = true;
                    // Also disable the hidden supply_id for this row
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
</body>
</html>