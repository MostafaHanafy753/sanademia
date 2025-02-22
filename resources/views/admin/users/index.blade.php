@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Users
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Users
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
                    <h3 class="block-title">Users Table </h3>
                </div>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Of Birth</th>
                            <th>Mobile Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($users))
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center fs-sm">{{ $user->id }}</td>
                                    <td class="fw-semibold fs-sm">{{ $user->name }}</td>
                                    <td class="fw-semibold fs-sm">{{ $user->email }}</td>
                                    <td class="fw-semibold fs-sm">{{ $user->date_of_birth != "" ? date("d-m-Y", strtotime($user->date_of_birth)) : "" }}</td>
                                    <td class="fw-semibold fs-sm">{{ $user->phone_code }} {{ $user->phone_number }}</td>
                                    <td class="fs-sm">
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                             {{-- <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button> --}}
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
