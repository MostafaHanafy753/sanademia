@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Create Category
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a class="link-fx" href="{{ url('admin/category') }}">Category</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Create Category
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
        <h3 class="block-title">
            Create Category
        </h3>
      </div>
      <div class="block-content">
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old("name") }}">
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-4">
              <label class="form-label" for="color_code">Color Code</label>
              <input type="text" class="form-control" id="color_code" name="color_code" placeholder="Color Code" value="{{ old("color_code") }}">
              @if ($errors->has('color_code'))
                  <div class="text-danger">{{ $errors->first('color_code') }}</div>
              @endif
          </div>

            <div class="mb-4">
                <label class="form-label" for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" >
                @if ($errors->has('image'))
                    <div class="text-danger">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div><br>

          </form>
      </div>
    </div>
    <!-- END Your Block -->
  </div>
  <!-- END Page Content -->
@endsection

@section('js')

<script src="{{ asset('') }}assets/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>

<script>One.helpersOnLoad(['js-ckeditor5']);</script>
@endsection
