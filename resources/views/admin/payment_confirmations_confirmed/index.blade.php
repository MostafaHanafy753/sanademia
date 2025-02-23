@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Payment Confirmations
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Payment Confirmations
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Tabs -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending" role="tab">
                            Pending <span class="badge bg-primary">3</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected" role="tab">
                            Rejected
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#confirmed" role="tab">
                            Confirmed
                        </button>
                    </li>
                </ul>
            </div>
            <div class="block-content">
                <div class="tab-content">
                    <!-- Pending Tab -->
                    <div class="tab-pane active" id="pending" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Applied At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example Row -->
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                                <div class="ms-2">John Doe</div>
                                            </div>
                                        </td>
                                        <td>$500.00</td>
                                        <td>Bank Transfer</td>
                                        <td>2023-07-20 14:32</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success me-1">
                                                <i class="fa fa-check"></i> Confirm
                                            </button>
                                            <button class="btn btn-sm btn-warning me-1">
                                                <i class="fa fa-pencil-alt"></i> Adjust
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i> Reject
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Rejected Tab -->
                    <div class="tab-pane" id="rejected" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Applied At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example Row -->
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                                                <div class="ms-2">Jane Smith</div>
                                            </div>
                                        </td>
                                        <td>$200.00</td>
                                        <td>Credit Card</td>
                                        <td>2023-07-18 09:15</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Confirmed Tab -->
                    <div class="tab-pane" id="confirmed" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Applied At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example Row -->
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar5.jpg') }}" alt="">
                                                <div class="ms-2">Mike Johnson</div>
                                            </div>
                                        </td>
                                        <td>$1000.00</td>
                                        <td>PayPal</td>
                                        <td>2023-07-15 16:45</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activate tab from URL hash if present
    const hash = window.location.hash;
    if (hash) {
        const trigger = document.querySelector(`[data-bs-target="${hash}"]`);
        if (trigger) {
            new bootstrap.Tab(trigger).show();
        }
    }

    // Add hash to URL when tab changes
    document.querySelectorAll('.nav-tabs button').forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', event => {
            window.location.hash = event.target.getAttribute('data-bs-target');
        });
    });
});
</script>
@endpush
