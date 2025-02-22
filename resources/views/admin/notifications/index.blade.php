@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Notifications
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Notifications
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
                <div class="col-md-10">
                    <h3 class="block-title">Notifications Table </h3>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.notification.create') }}" class="btn btn-primary float-end">+ Add</a>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($notifications))
                            @foreach ($notifications as $notification)
                                <tr>
                                    <td class="text-center fs-sm">{{ $notification->id }}</td>
                                    <td class="fw-semibold fs-sm">
                                        <img class="cup" alt="img" src="{{ $notification->image }}" width="50px">
                                    </td>
                                    <td class="fw-semibold fs-sm">{{ $notification->title }}</td>
                                    <td class="fs-sm">
                                        <form action="{{ route('admin.notification.destroy', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <a href="{{ route('admin.notification.edit', $notification->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                             <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
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
