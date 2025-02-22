@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Edit Question
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/exam/' . $Question->exam_id) }}">Question</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Edit Question
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
                    Edit Question
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.question.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $Question->id }}">
                    <div class="mb-4">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                            value="{{ old('title', $Question->title) }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>


                    <div class="mb-4">
                        <label class="form-label" for="type">Type</label>
                        <select class="form-control" id="type" name="type">
                            <option {{ old('type') == 'Option' ? 'selected' : '' }} {{ $Question->type == 'Option' ? 'selected' : '' }}>Option</option>
                            <option {{ old('type') == 'Audio' ? 'selected' : '' }} {{ $Question->type == 'Audio' ? 'selected' : '' }}>Audio</option>
                        </select>
                        @if ($errors->has('type'))
                            <div class="text-danger">{{ $errors->first('type') }}</div>
                        @endif
                    </div>

                    <div class="option_div">

                        <div class="mb-4">
                            <label class="form-label" for="option_1">Option 1</label>
                            <input type="text" class="form-control" id="option_1" name="option_1" placeholder="Option 1"
                                value="{{ old('option_1', $Question->option_1) }}">
                            @if ($errors->has('option_1'))
                                <div class="text-danger">{{ $errors->first('option_1') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="option_2">Option 2</label>
                            <input type="text" class="form-control" id="option_2" name="option_2" placeholder="Option 2"
                                value="{{ old('option_2', $Question->option_2) }}">
                            @if ($errors->has('option_2'))
                                <div class="text-danger">{{ $errors->first('option_2') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="option_3">Option 3</label>
                            <input type="text" class="form-control" id="option_3" name="option_3" placeholder="Option 3"
                                value="{{ old('option_3', $Question->option_3) }}">
                            @if ($errors->has('option_3'))
                                <div class="text-danger">{{ $errors->first('option_3') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="option_4">Option 4</label>
                            <input type="text" class="form-control" id="option_4" name="option_4" placeholder="Option 4"
                                value="{{ old('option_4', $Question->option_4) }}">
                            @if ($errors->has('option_4'))
                                <div class="text-danger">{{ $errors->first('option_4') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4 audio_div" style="display: none">
                        <label class="form-label" for="audio">Audio</label>
                        <input type="file" class="form-control" id="audio" name="audio">
                        @if ($Question->audio != "")
                            <a href="{{ $Question->audio }}" target="_blank">Audio</a>
                        @endif
                        @if ($errors->has('audio'))
                            <div class="text-danger">{{ $errors->first('audio') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="correct">Correct</label>
                        <input type="text" class="form-control" id="correct" name="correct" placeholder="Correct"
                            value="{{ old('correct', $Question->correct_ans) }}">
                        @if ($errors->has('correct'))
                            <div class="text-danger">{{ $errors->first('correct') }}</div>
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
    <script>
        $(document).ready(function() {

            $("#type").change(function(e) {
                e.preventDefault();

                type_check();
            });

            setTimeout(() => {
                type_check();
            }, 1000);
            function type_check(){
                var type = $("#type").find(":selected").val();
                if(type == "Audio"){
                  $(".audio_div").show();
                  $(".option_div").hide();
                } else {
                  $(".audio_div").hide();
                  $(".option_div").show();
                }
            }
        });
    </script>
@endsection
