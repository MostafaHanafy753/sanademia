@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Edit Course
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a class="link-fx" href="{{ route('admin.registration-form.courses.index') }}">Course</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Edit Course
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
            Edit Course
        </h3>
      </div>
      <div class="block-content">
        <form action="{{ route('admin.registration-form.courses.update',$Course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')



          <div class="mb-4">
              <label class="form-label" for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old("title", $Course->title) }}">
              @if ($errors->has('title'))
                  <div class="text-danger">{{ $errors->first('title') }}</div>
              @endif
          </div>

          <div class="mb-4">
              <label class="form-label" for="banner">Banner</label>
              <input type="file" class="form-control" id="banner" name="banner">
              @if ($errors->has('banner'))
                  <div class="text-danger">{{ $errors->first('banner') }}</div>
              @endif
              <br>
              <img src="{{ $Course->banner }}" alt="" width="100px">
          </div>


          <div class="mb-4">
            <label class="form-label" for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ old("price", $Course->price) }}">
            @if ($errors->has('price'))
                <div class="text-danger">{{ $errors->first('price') }}</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
    $(function () {
        tinymce.init({
            selector: 'textarea',
            height: 500,
            plugins: [
                "advlist autolink link responsivefilemanager lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality template paste textcolor colorpicker responsivefilemanager autoresize"
            ],
            // theme: 'modern',
        });
    });
</script>
@endsection
