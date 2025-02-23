@extends('layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Teacher Statements
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Teacher Statements
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Search Teacher</h3>
            </div>
            <div class="block-content">
                <form class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Teacher ID">
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
                <h3 class="block-title">Teacher Financial Statements</h3>
            </div>
            <div class="block-content table-responsive">
                <table class="table table-striped table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th>Total Incoming</th>
                            <th>Total Deservable</th>
                            <th>Total Withdrawals</th>
                            <th>Current Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                                    <div class="ms-2">
                                        <div>Jane Smith</div>
                                        <small class="text-muted">ID: T54321</small>
                                    </div>
                                </div>
                            </td>
                            <td>$5,000.00</td>
                            <td>$4,500.00</td>
                            <td>$1,200.00</td>
                            <td>$3,300.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
