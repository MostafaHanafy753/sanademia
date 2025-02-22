@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Get In Touch
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Get In Touch
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
        <form action="{{ url('admin/get-in-touch/store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label" for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ old("location", !empty($GetInTouch) ? $GetInTouch->location : '') }}">
                @if ($errors->has('location'))
                    <div class="text-danger">{{ $errors->first('location') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old("phone_number", !empty($GetInTouch) ? $GetInTouch->phone_number : '') }}">
                @if ($errors->has('phone_number'))
                    <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ old("email", !empty($GetInTouch) ? $GetInTouch->email : '') }}">
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
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
