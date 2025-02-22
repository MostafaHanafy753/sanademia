@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        User Enrolls
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/user') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            User Enrolls
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="col-md-12">
                    <h3 class="block-title">User Enrolls Table </h3>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th>Course</th>
                            <th>Payment ID</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($enrolls))
                            @foreach ($enrolls as $enroll)
                                <tr>
                                    <td class="text-center fs-sm">{{ $enroll->id }}</td>
                                    <td class="fw-semibold fs-sm">{{ $enroll->course ?  $enroll->course->title : "" }}</td>
                                    <td class="fw-semibold fs-sm">{{ $enroll->payment_id }}</td>
                                    <td class="fw-semibold fs-sm">{{ $enroll->payment_status }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
