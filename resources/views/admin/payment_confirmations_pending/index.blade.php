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
    <x-payment-confirmation-tabs/>

    <div class="container row mt-3">
        <div class="table-responsive">
            <table class="table">
                <thead>

                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Applied At</th>
                    <th>Confirm</th>
                    <th>Adjust</th>
                    <th>Reject</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>


@endsection
