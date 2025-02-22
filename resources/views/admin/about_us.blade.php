@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            About Us
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                About Us
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
          Abouts Us
        </h3>
      </div>
      <div class="block-content">
        <form action="{{ url('admin/about-us/store') }}" method="POST">
            @csrf

            <div class="mb-4">
              <!-- CKEditor 5 Classic Container -->
              <textarea id="js-ckeditor5-classic" name="description">{{ !empty($AboutUs) ? $AboutUs->description : "" }}</textarea>
                @if ($errors->has('description'))
                    <div class="text-danger">{{ $errors->first('description') }}</div>
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
