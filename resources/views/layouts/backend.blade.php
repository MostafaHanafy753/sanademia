<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title','Sana Academy')</title>

    <meta name="description" content="Sana Academy">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicon.ico') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('assets/media/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('') }}assets/css/oneui.min.css">

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/oneui/app.js'])

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{ asset('') }}assets/js/oneui.app.min.js"></script>
    <script src="{{ asset('') }}assets/js/lib/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables/dataTables.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
    <script src="{{ asset('') }}assets/js/pages/be_tables_datatables.min.js"></script>
    <script>
        @if (Session::has('success'))
            toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
        @endif

            @if (Session::has('error'))
            toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
        @endif

            @if (Session::has('info'))
            toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
        @endif

            @if (Session::has('warning'))
            toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>

    @stack('js')
</head>

<body>

<div id="page-container"
     class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
    <!-- Side Overlay-->
    <aside id="side-overlay" class="fs-sm">
        <!-- Side Header -->
        <div class="content-header border-bottom">
            <!-- User Avatar -->
            <a class="img-link me-1" href="javascript:void(0)">
                <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
            </a>
            <!-- END User Avatar -->

            <!-- User Info -->
            <div class="ms-2">
                <a class="text-dark fw-semibold fs-sm"
                   href="javascript:void(0)">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
            </div>
            <!-- END User Info -->

            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout"
               data-action="side_overlay_close">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Side Overlay -->
        </div>
        <!-- END Side Header -->

        <!-- Side Content -->
        <div class="content-side">
            <p>
                Content..
            </p>
        </div>
        <!-- END Side Content -->
    </aside>
    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <!--
        Sidebar Mini Mode - Display Helper classes

        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->
    <nav id="sidebar" aria-label="Main Navigation">
        <!-- Side Header -->
        <div class="content-header">
            <!-- Logo -->
            <a class="font-semibold text-dual" href="/">
                <span class="smini-visible">
                    <i class="fa fa-circle-notch text-primary"></i>
                </span>
                <span class="smini-hide d-block fs-5 tracking-wider">Sana Academy</span>
            </a>
            <!-- END Logo -->

            <!-- Extra -->
            <div>
                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="dark_mode_toggle"
                   href="javascript:void(0)">
                    <i class="far fa-moon"></i>
                </a>
                <!-- END Dark Mode -->


                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
                   href="javascript:void(0)">
                    <i class="fa fa-fw fa-times"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Extra -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side Navigation -->
            <div class="content-side">
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/dashboard') ? ' active' : '' }}"
                           href="{{ url('admin/dashboard') }}">
{{--                            <i class="nav-main-link-icon si si-cursor"></i>--}}
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.courses.index' || request()->is('course/statistics') || request()->is('course/create')? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Courses</span>
                        </a>
                        <ul class="nav-main-submenu">

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/category') ? ' active' : '' }}"
                                   href="{{ url('admin/category') }}">
                                    {{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Category</span>
                                </a>
                            </li>

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/course_content') ? ' active' : '' }}"
                                   href="{{ url('admin/course_content') }}">
                                    {{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Course Content</span>
                                </a>
                            </li>

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ Route::currentRouteName() == 'admin.courses.index'? ' active' : '' }}"
                                   href="{{route('admin.courses.index')}}">
                                    <span class="nav-main-link-name">Manage</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('course/statistics') ? ' active' : '' }}"
                                   href="/pages/slick">
                                    <span class="nav-main-link-name">Statistics</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Accounting</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ Route::currentRouteName() == 'admin.accounting.index'? ' active' : '' }}"
                                   href="{{route('admin.courses.index')}}">
                                    <span class="nav-main-link-name">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ \Illuminate\Support\Facades\Route::currentRouteNamed('dashboard.payment_confirmations.pending.index') ? ' active' : '' }}"
                                   href="{{route('dashboard.payment_confirmations.pending.index')}}">
                                    <span class="nav-main-link-name">Payment Confirmations</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Analysis</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">User's statements</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Teachers statements</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Payment Methods</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Costs & Spending</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Offers & Discounts</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/banner') ? ' active' : '' }}"
                           href="{{ url('admin/banner') }}">
                            <span class="nav-main-link-name">Banners & Ads</span>
                        </a>
                    </li>


                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Notifications</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/notification') ? ' active' : '' }}"
                                   href="{{ url('admin/notification') }}">
{{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Notification</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/slick">
                                    <span class="nav-main-link-name">SMS</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">WhatsApp</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Exams & Certificates</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/exam') ? ' active' : '' }}"
                                   href="{{ url('admin/exam') }}">
{{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Exam</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/slick">
                                    <span class="nav-main-link-name">Certificates</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/blank">
                                    <span class="nav-main-link-name">Requested Deliveries</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/teacher') ? ' active' : '' }}"
                           href="{{ url('admin/teacher') }}">
{{--                            <i class="nav-main-link-icon fa fa-users"></i>--}}
                            <span class="nav-main-link-name">Teacher</span>
                        </a>
                    </li>

                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Users</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ Route::currentRouteName() == 'admin.accounting.index'? ' active' : '' }}"
                                   href="{{route('admin.courses.index')}}">
                                    <span class="nav-main-link-name">Statistics</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('accounting') ? ' active' : '' }}"
                                   href="/pages/slick">
                                    <span class="nav-main-link-name">OTP</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Manage Pages</span>
                        </a>
                        <ul class="nav-main-submenu">

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/about-us') ? ' active' : '' }}"
                                   href="{{ url('admin/about-us') }}">
{{--                                    <i class="nav-main-link-icon fa fa-info-circle"></i>--}}
                                    <span class="nav-main-link-name">About Us</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/contact') ? ' active' : '' }}"
                                   href="{{ url('admin/contact') }}">
{{--                                    <i class="nav-main-link-icon fa fa-phone"></i>--}}
                                    <span class="nav-main-link-name">Contact</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/my-profile') ? ' active' : '' }}"
                           href="{{ url('admin/my-profile') }}">
{{--                            <i class="nav-main-link-icon fa fa-address-book"></i>--}}
                            <span class="nav-main-link-name">My Profile</span>
                        </a>
                    </li>

                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Forms & Surveys</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/registration-form/courses') ? ' active' : '' }}"
                                   href="{{ url('admin/registration-form/courses') }}">
                                    {{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Registration Form Courses</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/course_registrations') ? ' active' : '' }}"
                                   href="{{ url('admin/course_registrations') }}">

                                    <span class="nav-main-link-name">Registration Form</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/Survey') ? ' active' : '' }}"
                                   href="{{ url('admin/Survey') }}">
{{--                                    <i class="nav-main-link-icon fa fa-phone"></i>--}}
                                    <span class="nav-main-link-name">Survey</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/System Settings') ? ' active' : '' }}"
                           href="{{ url('admin/System Settings') }}">
{{--                            <i class="nav-main-link-icon fa fa-gear"></i>--}}
                            <span class="nav-main-link-name">System Settings</span>
                        </a>
                    </li>


                    <li class="nav-main-item{{Route::currentRouteName() == 'admin.accounting.index' ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="true" href="#">
                            <span class="nav-main-link-name">Extras</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/get-in-touch') ? ' active' : '' }}"
                                   href="{{ url('admin/get-in-touch') }}">
{{--                                    <i class="nav-main-link-icon fa fa-address-book"></i>--}}
                                    <span class="nav-main-link-name">Get In Touch</span>
                                </a>
                            </li>




                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/request_hard_copy') ? ' active' : '' }}"
                                   href="{{ url('admin/request_hard_copy') }}">
{{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">Request Hard Copy</span>
                                </a>
                            </li>

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/user') ? ' active' : '' }}"
                                   href="{{ url('admin/user') }}">
{{--                                    <i class="nav-main-link-icon fa fa-list-alt"></i>--}}
                                    <span class="nav-main-link-name">User</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{--                    <li class="nav-main-heading">Various</li>--}}
                    {{--                    <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">--}}
                    {{--                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"--}}
                    {{--                           aria-expanded="true" href="#">--}}
                    {{--                            <i class="nav-main-link-icon si si-bulb"></i>--}}
                    {{--                            <span class="nav-main-link-name">Examples</span>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav-main-submenu">--}}
                    {{--                            <li class="nav-main-item">--}}
                    {{--                                <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"--}}
                    {{--                                   href="/pages/datatables">--}}
                    {{--                                    <span class="nav-main-link-name">DataTables</span>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-main-item">--}}
                    {{--                                <a class="nav-main-link{{ request()->is('pages/slick') ? ' active' : '' }}"--}}
                    {{--                                   href="/pages/slick">--}}
                    {{--                                    <span class="nav-main-link-name">Slick Slider</span>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-main-item">--}}
                    {{--                                <a class="nav-main-link{{ request()->is('pages/blank') ? ' active' : '' }}"--}}
                    {{--                                   href="/pages/blank">--}}
                    {{--                                    <span class="nav-main-link-name">Blank</span>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-main-heading">More</li>--}}
                    {{--                    <li class="nav-main-item open">--}}
                    {{--                      <a class="nav-main-link" href="/">--}}
                    {{--                        <i class="nav-main-link-icon si si-globe"></i>--}}
                    {{--                        <span class="nav-main-link-name">Landing</span>--}}
                    {{--                      </a>--}}
                    {{--                    </li> --}}
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="d-flex align-items-center">
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                        data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- END Toggle Sidebar -->


                <!-- Search Form (visible on larger screens) -->
                {{-- <form class="d-none d-md-inline-block" action="/dashboard" method="POST">
                  @csrf
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-alt" placeholder="Search.." id="page-header-search-input2" name="page-header-search-input2">
                    <span class="input-group-text border-0">
                      <i class="fa fa-fw fa-search"></i>
                    </span>
                  </div>
                </form> --}}
                <!-- END Search Form -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="d-flex align-items-center">
                <!-- User Dropdown -->
                <div class="dropdown d-inline-block ms-2">
                    <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <img class="rounded-circle" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="Header Avatar"
                             style="width: 21px;">
                        <span
                            class="d-none d-sm-inline-block ms-2">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                        <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                         aria-labelledby="page-header-user-dropdown">
                        <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                            <img class="img-avatar img-avatar48 img-avatar-thumb"
                                 src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                            <p class="mt-2 mb-0 fw-medium">{{ auth()->user()->name }}</p>
                        </div>
                        {{-- <div class="p-2">
                          <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                            <span class="fs-sm fw-medium">Profile</span>
                            <span class="badge rounded-pill bg-primary ms-2">1</span>
                          </a>
                        </div> --}}
                        <div role="separator" class="dropdown-divider m-0"></div>
                        <div class="p-2">

                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                               href="{{ url('logout') }}">
                                <span class="fs-sm fw-medium">Log Out</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END User Dropdown -->

            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Search -->
        {{-- <div id="page-header-search" class="overlay-header bg-body-extra-light">
          <div class="content-header">
            <form class="w-100" action="/dashboard" method="POST">
              @csrf
              <div class="input-group">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                  <i class="fa fa-fw fa-times-circle"></i>
                </button>
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
              </div>
            </form>
          </div>
        </div> --}}
        <!-- END Header Search -->

        <!-- Header Loader -->
        <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-body-extra-light">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        @yield('content')
    </main>
    <!-- END Main Container -->

</div>
<!-- END Page Container -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ static_asset('assets/js/oneui.app.min.js') }}"></script>
@yield('js')
{!! displayAlert() !!}
</body>

</html>
