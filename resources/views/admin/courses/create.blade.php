@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Create Course
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/course') }}">Course</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Create Course
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
                    Create Course
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @if (!empty($Categories))
                                @foreach ($Categories as $Category)
                                    <option
                                        value="{{ $Category->id }}" {{ old("category_id") == $Category->id ? 'selected' : '' }}>{{ $Category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="teacher_id">Teacher</label>
                        <select class="form-control" id="teacher_id" name="teacher_id">
                            <option value="">Select Teacher</option>
                            @if (!empty($Teachers))
                                @foreach ($Teachers as $Teacher)
                                    <option
                                        value="{{ $Teacher->id }}" {{ old("teacher_id") == $Teacher->id ? 'selected' : '' }}>{{ $Teacher->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('teacher_id'))
                            <div class="text-danger">{{ $errors->first('teacher_id') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                               value="{{ old("title") }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="intro_video_thumbnail">Intro Video Thumbnail</label>
                        <input type="file" class="form-control" id="intro_video_thumbnail" name="intro_video_thumbnail">
                        @if ($errors->has('intro_video_thumbnail'))
                            <div class="text-danger">{{ $errors->first('intro_video_thumbnail') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="intro_video">Intro Video</label>
                        <input type="file" class="form-control" id="intro_video" name="intro_video"
                               placeholder="Video URL" value="{{ old("intro_video") }}">
                        @if ($errors->has('intro_video'))
                            <div class="text-danger">{{ $errors->first('intro_video') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="language">Language</label>
                        <input type="text" class="form-control" id="language" name="language" placeholder="Language"
                               value="{{ old("language") }}">
                        @if ($errors->has('language'))
                            <div class="text-danger">{{ $errors->first('language') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Price"
                               value="{{ old("price") }}">
                        @if ($errors->has('price'))
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="after_discount_price">Price After Discount</label>
                        <input type="number" class="form-control" id="after_discount_price" name="after_discount_price"
                               placeholder="Price After Discount" value="{{ old("after_discount_price") }}">
                        @if ($errors->has('after_discount_price'))
                            <div class="text-danger">{{ $errors->first('after_discount_price') }}</div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="discount">Discount</label>
                        <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount"
                               value="{{ old("discount") }}">
                        @if ($errors->has('discount'))
                            <div class="text-danger">{{ $errors->first('discount') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="task_included">Task Included</label>
                        <select class="form-control" id="task_included" name="task_included">
                            <option value="0" {{ old("task_included") == "0" ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old("task_included") == "1" ? 'selected' : '' }}>Yes</option>
                        </select>
                        @if ($errors->has('task_included'))
                            <div class="text-danger">{{ $errors->first('task_included') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="certificate">Certificate</label>
                        <select class="form-control" id="certificate" name="certificate">
                            <option value="0" {{ old("certificate") == "0" ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old("certificate") == "1" ? 'selected' : '' }}>Yes</option>
                        </select>
                        @if ($errors->has('certificate'))
                            <div class="text-danger">{{ $errors->first('certificate') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" rows="8" name="description"
                                  placeholder="Description">{{ old("description") }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-danger">{{ $errors->first('description') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="requirements">Requirements</label>
                        <textarea class="form-control" rows="8" name="requirements"
                                  placeholder="Requirements">{{ old("requirements") }}</textarea>
                        @if ($errors->has('requirements'))
                            <div class="text-danger">{{ $errors->first('requirements') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="what_will_you_learn">What will you learn</label>
                        <textarea class="form-control" rows="8" name="what_will_you_learn"
                                  placeholder="What will you learn">{{ old("what_will_you_learn") }}</textarea>
                        @if ($errors->has('what_will_you_learn'))
                            <div class="text-danger">{{ $errors->first('what_will_you_learn') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="who_this_course_is_for">Who this course is for</label>
                        <textarea class="form-control" rows="8" name="who_this_course_is_for"
                                  placeholder="Who this course is for">{{ old("who_this_course_is_for") }}</textarea>
                        @if ($errors->has('who_this_course_is_for'))
                            <div class="text-danger">{{ $errors->first('who_this_course_is_for') }}</div>
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
