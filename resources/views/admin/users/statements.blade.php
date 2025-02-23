@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        User Statements
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            User Statements
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Search User</h3>
            </div>
            <div class="block-content">
                <form class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="User ID">
                        </div>
                        <div class="col-md-3">
                            <input type="tel" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                <i class="fa fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">User Financial Statements</h3>
            </div>
            <div class="block-content table-responsive">
                <table class="table table-striped table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Current Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="clickable-row" data-bs-toggle="collapse" data-bs-target="#user1-details">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                    <div class="ms-2">
                                        <div>John Doe</div>
                                        <small class="text-muted">ID: U12345</small>
                                    </div>
                                </div>
                            </td>
                            <td>$1,500.00</td>
                        </tr>
                        <tr class="collapse" id="user1-details">
                            <td colspan="2">
                                <div class="p-3">
                                    <h6 class="mb-3">Transaction History</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Payment Method</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>+$500.00</td>
                                                <td><span class="badge bg-success">Deposit</span></td>
                                                <td>Credit Card</td>
                                                <td>2023-07-20 14:32</td>
                                            </tr>
                                            <tr>
                                                <td>-$200.00</td>
                                                <td><span class="badge bg-danger">Withdrawal</span></td>
                                                <td>PayPal</td>
                                                <td>2023-07-19 09:15</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
