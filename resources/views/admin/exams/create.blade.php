@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Create Exam
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a class="link-fx" href="{{ url('admin/exam') }}">Exam</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Create Exam
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
            Create Exam
        </h3>
      </div>
      <div class="block-content">
        <form action="{{ route('admin.exam.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="form-label" for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id">
                  <option value="">Select Course</option>
                  @if (!empty($Courses))
                      @foreach ($Courses as $Course)
                          <option value="{{ $Course->id }}" {{ old("course_id") == $Course->id ? 'selected' : '' }}>{{ $Course->title }}</option>
                      @endforeach
                  @endif
                </select>
                @if ($errors->has('course_id'))
                    <div class="text-danger">{{ $errors->first('course_id') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old("title") }}">
                @if ($errors->has('title'))
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="sub_title">Sub Title</label>
                <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Sub Title" value="{{ old("sub_title") }}">
                @if ($errors->has('sub_title'))
                    <div class="text-danger">{{ $errors->first('sub_title') }}</div>
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