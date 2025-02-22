@php use Mcamara\LaravelLocalization\Facades\LaravelLocalization; @endphp
    <!doctype html>
<html lang="{{LaravelLocalization::setLocale()}}"
      dir="@php if(LaravelLocalization::getCurrentLocaleScript() == 'Arab')echo 'rtl'; else echo 'ltr'; @endphp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@lang('registrationForm.course_registration')</title>
    <meta name="robots" content="index, follow">
    <link rel="shortcut icon" href="{{ static_asset('assets/media/favicon.ico')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ url('') }}/assets/css/oneui.min.css">

    @if (LaravelLocalization::getCurrentLocaleScript() == 'Arab')
        @vite('resources/sass/main.scss')
    @else
        @vite('resources/sass/main.scss')
    @endif
    @vite('resources/js/app.js')
    {{--    <link rel="stylesheet"  href="{{ static_static_asset('assets/css/form-registration.css')}}">--}}
    {{--    --}}
    <style>
        @if(isRtl())
        body * {
            direction: rtl;
        }

        @endif
        body[dir="rtl"] {
            direction: rtl;
            text-align: right;
            width: 100%;
        }

        body[dir="rtl"] * {
            direction: rtl;
        }

        .iti {
            width: 100%;
            /* Make the input full-width */
            margin-top: 8px;
        }

        .iti__selected-flag {
            border-radius: 50%;
        }

        .horizontal-heading {
            font-size: 40px;
        }


        .form-div {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .course-container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }


        .smalls-div {
            height: auto;
            margin-top: -25px;
            margin-bottom: 10px;
            position: relative;
        }

        .course-card {
            overflow: hidden;
            border: 1px solid #d4d2d2;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
            border-radius: 6px;
            margin-bottom: 1rem;
            padding: 5px;
        }

        .check-card {
            display: none;
        }

        .course-card img {
            border-radius: 4px 4px 0 0;
            /* Top rounded corners only */
            object-fit: cover;
            width: 100%;
            /*min-height: 200px;*/
            height: auto;
        }

        .course-card .card-body {
            border-radius: 0;
            padding: 0;
            /* Bottom rounded corners only */
        }

        .course-card.checked {
            border: 2px solid #1E848C;
            /* box-shadow: 0 0 15px rgba(0, 123, 255, 0.7); */
            box-shadow: 0 0 2px rgb(30, 132, 140, 0.5);
            transform: scale(1.02);
            background-color: rgba(0, 123, 255, 0.1);
            position: relative;

        }

        .course-card.checked .check-card {
            position: absolute;
            top: 0;
            right: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25px;
            height: 25px;
            margin-top: 1rem;
        }

        .course-card.checked .card-body {
            background-color: rgba(0, 0, 0, 0.05);
            /* Slightly darker card body */
            color: #333;
            /* transition: background-color 0.3s, color 0.3s; */
        }

        .course-card.checked:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 123, 255, 0.090);

            z-index: 0;
            pointer-events: none;
            /* Ensure interactivity isn't blocked */
        }

        .main-course-card {
            width: 97%;
        }

        .horizontal-img-container {
            width: 100%;
            height: 13rem;
            overflow: hidden;
            position: relative;
            padding: 10px 0;
        }

        .horizontal-img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .logo {
            width: auto;
            max-width: 70%;
            /*height: 100%;*/
            max-height: 40%;
            object-fit: scale-down;
        }

        @media (max-width: 365px) and (min-width: 270px) {
            .course-card img {
                /*min-height: 136px;*/
                height: auto;
            }
        }
        @media (max-width: 440px) and (min-width: 366px) {
            .course-card img {
                /*min-height: 160px;*/
                height: auto;
            }
        }
        @media (max-width: 575px) and (min-width: 441px) {
            .course-card img {
                /*min-height: 65px !important;*/
                height: auto;
            }

            .col-sm-6 {
                flex: 0 0 auto;
                width: 50%;
            }
        }


        .btn {
            font-size: 1.3rem;
        }

        @media (max-width: 576px) {
            .header-text {
                font-size: 0.8rem;
                text-align: center;
                max-width: 85%;
            }

            .horizontal-img-container {
                height: 10rem;
                background-position: top;
            }

            .course-card.checked .check-card {
                width: 16px;
                height: 16px;
            }

            .course-card.checked .check-card i {
                font-size: 10px;
            }

            .block {
                padding: 1rem;
            }

            .form-label {
                font-size: 1rem;
            }

            .btn {
                font-size: 1rem;
            }


            .horizontal-scroll {
                display: flex;
                margin-top: -10px;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: -3rem;
                /* overflow-x: hidden; */
            }

            /*
             .horizontal-scroll::-webkit-scrollbar {
                display: none;
            } */
            .course-card {
                flex: 0 0 auto;
                margin-bottom: 0%;
            }

            .course-heading {
                font-size: 1.5rem;
            }


            .course-card {
                /*width: 35%;*/
                /*height: 40%;*/
                display: flex;
                /*margin-top: -10px;*/
                /*margin-left: -20px;*/
                margin: 10px 0px;

            }

            .course-card img {
                /*min-height: 160px;*/
                height: auto;
            }

            .small-hours {
                font-size: 0.7rem;
                margin-top: -20px;
                margin-left: 10px;
            }

            .small-lecture {
                font-size: 0.7rem;
                margin-left: -5px;
            }

            .small-instructor {
                font-size: 0.7rem;
                padding: 0;
            }

            .small-price {
                font-size: 0.7rem;
                padding: 0%;
            }

            .card-title {
                font-size: 1rem;
                text-align: left;
            }

            .sm-smalls {
                justify-content: left;
                float: left;

            }

            .horizontal-heading {
                font-size: 1rem;
                margin-top: -10px
            }

            .select-course {
                font-size: 1rem;
                margin-left: -17px;
                /* margin-bottom: ; */
            }

            .card-img-top {
                width: 100%;
                object-fit: cover;
            }

            .small-div {
                margin-top: -18px;
                /* margin */
            }

            .form-div {
                padding-top: 10px;
                padding-bottom: 0px;
            }

            .course-container {
                padding-left: 0px;
                padding-right: 0px;
            }

            .course-card img {
                /*min-height: 160px;*/
                height: auto;
            }

            .smalls-div {
                margin-left: -5px;
                margin-top: -15px;
            }

            .course-card.checked .check-card .check-right {
                text-align: center;
            }

        }

        @media (max-width: 744px) and (min-width: 577px) {
            .header-text {
                font-size: 14px;
                text-align: center;
                max-width: 85%;
            }

            .horizontal-img-container {
                height: 10rem;
            }

            .course-card.checked .check-card {

                width: 20px;
                height: 20px;
            }

            .course-card.checked .check-card i {
                font-size: 14px;
            }

            .form-label {
                font-size: 1rem;
            }

            .btn {
                font-size: 1.1rem;
            }


            /*
             .horizontal-scroll::-webkit-scrollbar {
                display: none;
            } */
            .course-card {
                flex: 0 0 auto;
                margin-bottom: 0%;
            }

            .course-heading {
                font-size: 1.8rem;
            }


            .course-card {
                /*width: 35%;*/
                /*height: 40%;*/
                display: flex;
                /*margin-top: -10px;*/
                /*margin-left: -20px;*/
                margin: 10px 0px;

            }

            .course-card img {
                /*min-height: 150px;*/
                height: auto;
            }

            .small-hours {
                font-size: 0.7rem;
                margin-top: -20px;
                margin-left: 10px;
            }

            .small-lecture {
                font-size: 0.7rem;
                margin-left: -5px;
            }

            .small-instructor {
                font-size: 0.8rem;
                padding: 0;
            }

            .small-price {
                font-size: 0.8rem;
                padding: 0%;
            }

            .card-title {
                font-size: 0.8rem;
                text-align: left;
            }

            .sm-smalls {
                justify-content: left;
                float: left;

            }

            .horizontal-heading {
                font-size: 1.5rem;
                margin-top: -10px
            }

            .select-course {
                font-size: 1.2rem;
                /*margin-left: -17px;*/
                /* margin-bottom: ; */
            }

            .card-img-top {
                width: 100%;
                object-fit: cover;
            }

            .small-div {
                margin-top: -18px;
                /* margin */
            }

            .form-div {
                padding-top: 10px;
                padding-bottom: 0px;
            }

            .course-container {
                padding-left: 0px;
                padding-right: 0px;
            }

            .course-card img {

                object-fit: cover;
            }

            .smalls-div {
                margin-left: -5px;
                margin-top: -15px;
            }

            .course-card.checked .check-card .check-right {
                text-align: center;
            }


        }

        @media (min-width: 745px) and (max-width: 992px) {
            .header-text {
                font-size: 1rem;
                text-align: center;
                max-width: 85%;
            }

            .horizontal-img-container {
                height: 12rem;
            }

            .course-card.checked .check-card {

                width: 25px;
                height: 25px;
            }

            .course-card.checked .check-card i {
                font-size: 16px;
            }

            .form-label {
                font-size: 1.2rem;
            }

            .btn {
                font-size: 1.3rem;
            }

            .horizontal-scroll {
                display: flex;
                margin-top: -10px;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: -3rem;
                /* overflow-x: hidden; */
            }

            /*
             .horizontal-scroll::-webkit-scrollbar {
                display: none;
            } */
            .course-card {
                flex: 0 0 auto;
                margin-bottom: 0%;
            }

            .course-heading {
                font-size: 1.5rem;
            }

        }

        @media (min-width: 993px) and (max-width: 1200px) {
            .header-text {
                font-size: 1.2rem;
                text-align: center;
                max-width: 85%;
            }

            .horizontal-img-container {
                height: 13.5rem;
            }

            .course-card.checked .check-card {

                width: 25px;
                height: 25px;
            }

            .course-card.checked .check-card i {
                font-size: 16px;
            }

            .form-label {
                font-size: 1.2rem;
            }

            .btn {
                font-size: 1.3rem;
            }

            .horizontal-scroll {
                display: flex;
                margin-top: -10px;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: -3rem;
                /* overflow-x: hidden; */
            }

            /*
             .horizontal-scroll::-webkit-scrollbar {
                display: none;
            } */
            .course-card {
                flex: 0 0 auto;
                margin-bottom: 0%;
            }

            .course-heading {
                font-size: 1.5rem;
            }

        }

        @media  (min-width: 1201px) {
            .header-text {
                font-size: 1.4rem;
                text-align: center;
                max-width: 85%;
            }

            .horizontal-img-container {
                height: 14.5rem;
            }

        }
        .card-title {
            font-size: 1rem;
            text-align: left;
        }

    </style>

    <!-- SweetAlert2 JavaScript -->
{{--    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
</head>

<body
    class="bg-light position-relative w-100 @php if(LaravelLocalization::getCurrentLocaleScript() == 'Arab')echo 'rtl-support';  @endphp"
    dir="@php if(LaravelLocalization::getCurrentLocaleScript() == 'Arab')echo 'rtl'; else echo 'ltr'; @endphp">

{{--<div class="position-fixed"--}}
{{--     style="z-index: 10;@php if(LaravelLocalization::getCurrentLocaleScript() == 'Arab')echo 'right: 10px'; else echo 'left: 10px'; @endphp;;top: 10px">--}}

{{--    <div class="dropdown show">--}}
{{--        <a class="btn btn-light btn-sm dropdown-toggle fs-6" href="#" role="button" id="dropdownMenuLink"--}}
{{--           data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--            {{ LaravelLocalization::getCurrentLocaleNativeReading() }}--}}
{{--            @if(LaravelLocalization::setLocale()=='ku')--}}

{{--                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="35px"--}}
{{--                     style="border-radius: 3px;"--}}
{{--                     height="23px" viewBox="0 0 34 23" version="1.1">--}}
{{--                    <g id="surface1">--}}
{{--                        <rect x="0" y="0" width="34" height="23"--}}
{{--                              style="fill:rgb(100%,100%,100%);fill-opacity:1;stroke:none;"/>--}}
{{--                        <path--}}
{{--                            style=" stroke:none;fill-rule:nonzero;fill:rgb(92.941177%,12.54902%,14.117648%);fill-opacity:1;"--}}
{{--                            d="M 0 0 L 34 0 L 34 7.667969 L 0 7.667969 Z M 0 0 "/>--}}
{{--                        <path--}}
{{--                            style=" stroke:none;fill-rule:nonzero;fill:rgb(15.294118%,55.686277%,26.274511%);fill-opacity:1;"--}}
{{--                            d="M 0 15.332031 L 34 15.332031 L 34 23 L 0 23 Z M 0 15.332031 "/>--}}
{{--                        <path--}}
{{--                            style=" stroke:none;fill-rule:nonzero;fill:rgb(99.607843%,74.117649%,6.666667%);fill-opacity:1;"--}}
{{--                            d="M 17 5.75 L 17.425781 8.671875 L 18.679688 6.007812 L 18.234375 8.925781 L 20.210938 6.753906 L 18.9375 9.414062 L 21.457031 7.925781 L 19.46875 10.085938 L 22.304688 9.417969 L 19.777344 10.890625 L 22.683594 11.101562 L 19.839844 11.75 L 22.554688 12.820312 L 19.652344 12.589844 L 21.933594 14.421875 L 19.226562 13.335938 L 20.875 15.769531 L 18.605469 13.921875 L 19.472656 16.742188 L 17.839844 14.296875 L 17.847656 17.25 L 17 14.421875 L 16.152344 17.25 L 16.160156 14.296875 L 14.527344 16.742188 L 15.394531 13.921875 L 13.125 15.769531 L 14.773438 13.335938 L 12.066406 14.421875 L 14.347656 12.589844 L 11.445312 12.820312 L 14.160156 11.75 L 11.316406 11.101562 L 14.222656 10.890625 L 11.695312 9.417969 L 14.53125 10.085938 L 12.542969 7.925781 L 15.0625 9.414062 L 13.789062 6.753906 L 15.765625 8.925781 L 15.320312 6.007812 L 16.574219 8.671875 Z M 17 5.75 "/>--}}
{{--                    </g>--}}
{{--                </svg>--}}
{{--            @elseif(LaravelLocalization::setLocale()=='en')--}}
{{--                <span class="fi fi-gb " style="border-radius: 2px;"></span>--}}
{{--            @endif--}}
{{--        </a>--}}
{{--        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
{{--            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
{{--                <a class="dropdown-item" hreflang="{{ $localeCode }}"--}}
{{--                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
{{--                    {{ $properties['native'] }}--}}
{{--                </a>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}


<div id="page-container">
    <div class="w-100  d-flex flex-column justify-content-center align-items-center horizontal-img-container"
         style="background-image: url('{{static_asset('assets/media/background.png')}}');background-repeat: repeat;


       ">
        <img src="{{static_asset('assets/media/white-logo.png')}}" class="logo" alt="logo">
        <h5 class="text-white mt-2 header-text text-center">
            {!! trans('registrationForm.welcome') !!}
            <a href="https://api.whatsapp.com/send/?phone=9647509790444&text&type=phone_number&app_absent=0" class="text-white" target="_blank">
                +9647509790444
            </a>
        </h5>
    </div>
    <main id="main-container">
        <div class="hero-static d-flex align-items-center">
            <div class="content">
                <div class="row justify-content-center push">
                    <div class=" main-course-card">
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-2">
                                <form class="js-validation-register" action="{{ route('registration') }}"
                                      method="POST">
                                    @csrf
                                    <div class=" form-div">
                                        <h4 class=" select-course">
                                            @lang('registrationForm.select_courses')
                                        </h4>
                                        <div class="row col-sm-12  d-flex flex-wrap">
                                            @if(isset($courses))
                                                @foreach ($courses as $course)
                                                    <div class="col-sm-6 col-md-4 col-xl-4  col-6 course-container">
                                                        <div class="card bg-light course-card"
                                                             data-id="{{ $course->id }}">
                                                            <img src="{{ $course->banner }}"
                                                                 class="card-img-top img-fluid"
                                                                 alt="{{ $course->title }}"
                                                                 style="object-fit: scale-down">

                                                            @if(!empty($course->price))
                                                                <div
                                                                    class="d-flex flex-row justify-content-between smalls-div w-100 px-1">
                                                                    <small
                                                                        class="py-1 px-1 bg-white  small-price"
                                                                        style="border-radius:8px; right: 0;">
                                                                        @lang('registrationForm.price'):
                                                                        <b>{{ $course->price }}</b>
                                                                    </small>
                                                                </div>
                                                            @endif


                                                            <div class="card-body bg-light mt-4 sm-smalls px-2 mb-3">
                                                                <h4 class="card-title text-center mb-3"
                                                                    dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                                                    {{ $course->title }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @elseif(isset($course))
                                                <div class="col-sm-6 col-md-6 col-xl-4  col-12 course-container">
                                                    <input type="hidden" name="courses[]" value="{{$course->id}}">
                                                    <div class="card bg-light course-card checked"
                                                         data-id="{{ $course->id }}">
                                                        <img src="{{ $course->banner }}"
                                                             class="card-img-top img-fluid"
                                                             alt="{{ $course->title }}">

                                                        @if(!empty($course->price))
                                                            <div
                                                                class="d-flex flex-row justify-content-between smalls-div w-100 px-1">
                                                                <small
                                                                    class="py-1 px-1 bg-white  small-price"
                                                                    style="border-radius:8px; right: 0;">
                                                                    @lang('registrationForm.price'):
                                                                    <b>${{ $course->price }}</b>
                                                                </small>
                                                            </div>
                                                        @endif


                                                        <div class="card-body bg-light mt-4 sm-smalls px-2 mb-3">
                                                            <h4 class="card-title text-center mb-3"
                                                                dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                                                {{ $course->title }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    <hr class="m-0 mb-2">

                                    <div class="py-3 pt-0 mt-0" dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                        <h1 class=" select-course mt-3" dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                            @lang('registrationForm.personal_information')
                                        </h1>
                                        <div class="mb-3 col-12 row" style="direction: ltr">
                                            <div class="col-md-6 col-12 my-1">
                                                <label for="full_name" class="form-label text-muted">
                                                    @lang('registrationForm.full_name')
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="full_name" id="full_name"
                                                       class="form-control rounded-lg mt-2"
                                                       placeholder="{{trans('registrationForm.enter_your_full_name')}}"
                                                       style="height: 50px;border-radius:10px;" required
                                                       dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                            </div>

                                            <div class="col-md-6 col-12  my-1">
                                                <label for="phone_no" class="form-label text-end text-muted">
                                                    @lang('registrationForm.phone_number')
                                                    <span class="text-danger">*</span></label><br>
                                                <input type="tel" name="phone_no" id="phone_no"
                                                       class="form-control py-2 rounded-lg mt-4 col-md-12"
                                                       placeholder=" ---- ---- ----"
                                                       style="height: 50px;border-radius:10px;" required
                                                >
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="form-label mt-2 mb-3 form-label">
                                                @lang('registrationForm.select_how_you_want_to_take_the_course')
                                            </label>
                                            <div class="row">
                                                <div class="col-md-6  col-12 p-1">

                                                    <input type="radio" class="btn-check d-none"
                                                           name="course_mode" id="in_class" value="in_class"
                                                           autocomplete="off"
                                                           dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                                    <label class="btn btn-outline-primary col-12 py-2"
                                                           dir="{{ isRtl() ? 'rtl' : 'ltr' }}"
                                                           for="in_class" style="height: 50px"><i class="fa-solid fa-person-chalkboard"></i> @lang('registrationForm.in_class')
                                                    </label>
                                                </div>
                                                <div class="col-md-6  col-12 p-1">

                                                    <input type="radio" class="btn-check d-none"
                                                           name="course_mode" id="online" value="online"
                                                           autocomplete="off"
                                                           dir="{{ isRtl() ? 'rtl' : 'ltr' }}">
                                                    <label class="btn btn-outline-primary col-12 py-2"
                                                           dir="{{ isRtl() ? 'rtl' : 'ltr' }}"
                                                           for="online" style="height: 50px"><i
                                                            class="fa-solid fa-computer"></i> @lang('registrationForm.online')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selected_courses_container">
                                    </div>


                                    <div class="row mb-4 d-flex justify-content-center">

                                        <button type="submit" class="w-100 btn btn-primary py-2 "
                                                style="border-radius: 10px">
                                            <i class="fa fa-fw fa-sign-in-alt opacity-50"></i>
                                            @lang('registrationForm.submit')
                                        </button>

                                    </div>
                                </form>
                                <!-- END Register Form -->
                            </div>
                        </div>
                        <!-- END Register Block -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
{{--<script src="{{ url('') }}/assets/js/oneui.app.min.js"></script>--}}
<script src="{{ url('') }}/assets/js/lib/jquery.min.js"></script>

<script>
    @if(isset($courses))
    $(document).ready(function () {
        $('.course-card').on('click', function () {
            $(this).toggleClass('checked');
            updateSelectedCourses();
        });

        function updateSelectedCourses() {
            let selectedCourses = [];
            $('#selected_courses_container').empty();
            $('.course-card.checked').each(function () {
                const courseId = $(this).data('id');
                // Create a new hidden input for each selected course
                const input = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'courses[]') // Use array notation for the name
                    .val(courseId); // Set the value to the course ID

                // Append the input to the container
                $('#selected_courses_container').append(input);
            });
        }
    });
    @endif


    const full_nameInput = document.querySelector("#full_name");
    //make the length 25 char
    full_nameInput.addEventListener('input', function () {
        if (full_nameInput.value.length > 25) {
            full_nameInput.value = full_nameInput.value.slice(0, 25);
        }
    });

    const phoneInput = document.querySelector("#phone_no");


    const iti = intlTelInput(phoneInput, {
        initialCountry: "auto",
        geoIpLookup: function (callback) {
            fetch("https://ipinfo.io/json")
                .then((response) => response.json())
                .then((data) => callback(data.country))
                .catch(() => callback("US"));
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });

    //validate phone number on writing and if the length is too long stop writing
    phoneInput.addEventListener('input', function () {
        if (!iti.isValidNumber()) {
            const errorCode = iti.getValidationError();
            if (errorCode === intlTelInputUtils.validationError.TOO_LONG) {
                phoneInput.value = phoneInput.value.slice(0, -1);
            }
        }

    });


    // Add validation logic
    function validatePhoneNumber() {
        const phoneNumber = phoneInput.value.trim();

        if (!phoneNumber) {
            Swal.fire({
                icon: 'error',
                title: '{{trans('registrationForm.oops')}}',
                text: 'Phone number is required',
                showConfirmButton: false,
                timer: 2000,

            });
            return false;
        }

        if (!iti.isValidNumber()) {
            const errorCode = iti.getValidationError();
            Swal.fire({
                icon: 'error',
                title: '{{ trans("registrationForm.oops") }}',
                text: getErrorMessage(errorCode),
                showConfirmButton: false,
                timer: 2000
            });

            return false;
        }
        return true;
    }

    // Helper function to get error message
    function getErrorMessage(errorCode) {
        switch (errorCode) {
            case intlTelInputUtils.validationError.INVALID_COUNTRY_CODE:
                return "Invalid country code";
            case intlTelInputUtils.validationError.TOO_SHORT:
                return "Phone number is too short";
            case intlTelInputUtils.validationError.TOO_LONG:
                return "Phone number is too long";
            case intlTelInputUtils.validationError.NOT_A_NUMBER:
                return "Invalid phone number format";
            default:
                return "Invalid phone number";
        }
    }

    // Example usage in form submission
    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();

        let course_mode = document.querySelector('input[name="course_mode"]:checked');
        if (!course_mode) {
            Swal.fire({
                icon: 'error',
                title: '{{trans('registrationForm.oops')}}',
                text: 'Please select how you want to take the course',
                showConfirmButton: false,
                timer: 2000,
            });
            return;
        }

        if (validatePhoneNumber()) {
            // Valid phone number - proceed with submission
            const formattedNumber = iti.getNumber();
            phoneInput.value = formattedNumber;
            //check if courses selected
            if (document.querySelectorAll('.course-card.checked').length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: '{{trans('registrationForm.oops')}}',
                    text: 'Please select at least one course',
                    showConfirmButton: false,
                    timer: 2000,
                });
                return;
            }

            this.submit();
        }
    });

    // phoneInput.addEventListener("blur", function () {
    //     if (iti.isValidNumber()) {
    //          // Retrieves the full number with country code
    //         phoneInput.value = iti.getNumber();
    //     } else {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Invalid phone number',
    //         });
    //
    //     }
    // });
</script>
{!! displayAlert() !!}
</body>

</html>
