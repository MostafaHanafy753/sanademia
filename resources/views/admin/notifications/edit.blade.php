@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Edit Notification
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a class="link-fx" href="{{ url('admin/notification') }}">Notification</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Edit Notification
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
            Edit Notification
        </h3>
      </div>
      <div class="block-content">
        <form action="{{ route('admin.notification.update',$notification->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old("title", $notification->title) }}">
                @if ($errors->has('title'))
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" >
                @if ($errors->has('image'))
                    <div class="text-danger">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <div class="mb-4">
              <label class="form-label" for="description">Description</label>
              <textarea id="js-ckeditor5-classic" name="description">{{ old("description", $notification->description) }}</textarea>
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
