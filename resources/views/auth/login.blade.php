<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8"/>
    <title>MadaresonaJo | Login Page</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->


    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/classic/login-57a4a.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Custom Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle7a4a.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle7a4a.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle7a4a.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->

    <link href="{{ asset('assets/css/themes/layout/header/base/light7a4a.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/header/menu/light7a4a.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/brand/dark7a4a.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/aside/dark7a4a.css?v=7.0.4') }}" rel="stylesheet" type="text/css"/>
    <!--end::Layout Themes-->

    <link rel="shortcut icon"
          href="{{ asset('assets/media/logos/header_logo.png') }}"/>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-37564768-1');
    </script>
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid"
             style="background-image: url({{ asset('') }}assets/media/bg/bg-2.jpg);">
            <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="{{ asset('assets/media/logos/madaresona_logo.png') }}" class="max-h-125px" alt=""/>
                    </a>
                </div>
                <!--end::Login Header-->

                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    <div class="mb-20">
                        <h3 class="opacity-40 font-weight-normal">Sign In To Dashboard</h3>
                        <p class="opacity-40">Enter your details to login to your account:</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" type="email" placeholder="Email"
                                   class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="Password"
                                   class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
                            <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                                <span></span>
                            </label>
                            <a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget
                                Password ?</a>
                        </div>
                        <div class="form-group text-center mt-10">
                            <button type="submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">
                                {{ __('Login') }}
                            </button>

                        </div>
                    </form>

                </div>
                @if(session()->has('active'))
                    <div class="alert alert-danger">{{ session('active') }}</div>
                    @endif

                <div class="login-forgot">
                    <div class="mb-20">
                        <h3 class="opacity-40 font-weight-normal">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </h3>
                        <p class="opacity-40">Enter your email to reset your password</p>
                    </div>
                    <form class="form" id="kt_login_forgot_form">
                        <div class="form-group mb-10">
                            <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8"
                                   type="text" placeholder="Email" name="email" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <button id="kt_login_forgot_submit"
                                    class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Request
                            </button>
                            <button id="kt_login_forgot_cancel"
                                    class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->


<!--end::Page Scripts-->
</body>
<!--end::Body-->

<!-- Mirrored from keenthemes.com/metronic/preview/demo1/custom/pages/login/classic/login-5.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Jun 2020 14:27:31 GMT -->
</html>

