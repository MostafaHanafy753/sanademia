<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Login</title>

    <meta name="description" content="Login">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Sana Academy">
    <meta property="og:site_name" content="Sana Academy">
    <meta property="og:description" content="Sana Academy">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ url('') }}/assets/media/favicon.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('') }}/assets/media/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('') }}/assets/media/favicon.ico">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- OneUI framework -->
    {{--    <link rel="stylesheet" id="css-main" href="{{ url('') }}/assets/css/oneui.min.css">--}}
    @vite('resources/sass/main.scss')
</head>

<body>
<!-- Page Container -->

<div id="page-container">

    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="hero-static d-flex align-items-center">
            <div class="content">
                <div class="row justify-content-center push">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <!-- Sign In Block -->
                        <div class="block block-rounded mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Sign In</h3>
                                <div class="block-options">
                                    {{-- <a class="btn-block-option fs-sm" href="op_auth_reminder.html">Forgot Password?</a>
                                    <a class="btn-block-option" href="op_auth_signup.html" data-bs-toggle="tooltip" data-bs-placement="left" title="New Account">
                                      <i class="fa fa-user-plus"></i>
                                    </a> --}}
                                </div>
                            </div>
                            <div class="block-content">
                                <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                    <h1 class="h2 mb-1">Sana Academy</h1>
                                    <p class="fw-medium text-muted">
                                        Welcome, please login.
                                    </p>

                                    <form class="js-validation-signin" action="{{ url('post-login') }}" method="POST">
                                        @csrf
                                        @method('POST')

                                        @if ($message = Session::get('error'))
                                            <div class="text text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif

                                        <div class="py-3">
                                            <div class="mb-4">
                                                <input type="text" class="form-control form-control-alt form-control-lg"
                                                       id="email" name="email" placeholder="Email">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-4">
                                                <input type="password"
                                                       class="form-control form-control-alt form-control-lg"
                                                       id="password" name="password" placeholder="Password">
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            {{-- <div class="mb-4">
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="login-remember" name="login-remember">
                                                <label class="form-check-label" for="login-remember">Remember Me</label>
                                              </div>
                                            </div> --}}
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6 col-xl-5">
                                                <button type="submit" class="btn w-100 btn-alt-primary">
                                                    <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Sign In
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>
                        </div>
                        <!-- END Sign In Block -->
                    </div>
                </div>
                {{-- <div class="fs-sm text-muted text-center">
                  <strong>OneUI 5.9</strong> &copy; <span data-toggle="year-copy"></span>
                </div> --}}
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>

<script src="{{ url('') }}/assets/js/oneui.app.min.js"></script>
<script src="{{ url('') }}/assets/js/lib/jquery.min.js"></script>
<script src="{{ url('') }}/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="{{ url('') }}/assets/js/pages/op_auth_signin.min.js"></script>
</body>
</html>
