<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<!-- Mirrored from keenthemes.com/metronic/preview/demo1/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Jun 2020 14:21:59 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8"/>
    <title>MadaresonaJo | Dashboard</title>
    <meta name="description" content="Updates and statistics"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle7a4a.css') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->
    <link href="{{ asset('assets/css/pages/wizard/wizard-37a4a.css') }}" rel="stylesheet" type="text/css"/>
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->

    <link href="{{ asset('assets/css/themes/layout/header/base/light7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/aside/dark7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/header/menu/light7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/themes/layout/aside/dark7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle7a4a.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/smartwizard/css/smart_wizard.css') }}">
    <!--end::Layout Themes-->
    <link rel="shortcut icon"
          href="{{ asset('assets/media/logos/header_logo.png') }}"/>

@yield('css')

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
@include('partials.mobileHeader')
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">

    @include('partials.aside')
    <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
        @include('partials.header')

        <!--begin::Content-->
            <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                @include('partials.subHeader')

                @yield('content')
            </div>

            <!--end::Content-->

            @include('partials.footer')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->


@include('partials.userPanel')


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnpiNImmRHQBxmLIn5o_zTBufGgXzZBko&language=en&region=JO&libraries=places&callback=initAutocomplete"></script>

<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle7a4a.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle7a4a.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle7a4a.js') }}"></script>

<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle7a4a.js') }}"></script>
<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('assets/js/pages/widgets7a4a.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle7a4a.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle7a4a.js') }}"></script>

<script>

    $('.reset_password').on('click', function () {
        $.ajax({
            url: '{{ route('resetPassword') }}',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Reset Password');
                $('#schoolModal').modal('show');

                $('#resetPassForm').submit(function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: new FormData(this),
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {

                            if (data.status === 422) {
                                console.log(data);
                                var error_html = '';

                                for (let value of Object.values(data.errors)) {
                                    error_html += '<div class="alert alert-danger">' + value + '</div>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: error_html,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#schoolModal').modal('hide');
                            }
                        }
                    });

                });
            }
        });

    });
</script>
@yield('script')

</body>
<!--end::Body-->

<!-- Mirrored from keenthemes.com/metronic/preview/demo1/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Jun 2020 14:25:22 GMT -->
</html>
