@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Create Course Content
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/course_content') }}">Course Content</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Create Course Content
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
                    Create Course Content
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.courses.contents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="course_id" value="{{$course->id}}" required>


                    <div class="mb-4">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                               value="{{ old("title") }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    {{-- <div class="mb-4">
                        <label class="form-label" for="number_of_lecture">Number of Lecture</label>
                        <input type="number" class="form-control" id="number_of_lecture" name="number_of_lecture" placeholder="Number of Lecture" value="{{ old("number_of_lecture") }}">
                        @if ($errors->has('number_of_lecture'))
                            <div class="text-danger">{{ $errors->first('number_of_lecture') }}</div>
                        @endif
                    </div> --}}

                    <div class="mb-4">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" rows="8" name="description"
                                  placeholder="Description">{{ old("description") }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-danger">{{ $errors->first('description') }}</div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <br>

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
