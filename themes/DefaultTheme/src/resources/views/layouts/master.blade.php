<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <!-- viewport meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <script type="text/javascript">
        window.RAYCHAT_TOKEN = "3aef2e2a-3509-4be0-86cf-1fadca555e38";
        (function () {
            d = document;
            s = d.createElement("script");
            s.src = "https://widget-react.raychat.io/install/widget.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>

    @stack('meta')

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ option('info_icon', theme_asset('images/favicon-32x32.png')) }}">

    <title>
        @isset($title)
            {{ $title }} |
        @endisset

        {{ option('info_site_title', 'فن وب') }}
    </title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/materialdesignicons.min.css') }}">

    @stack('befor-styles')

    <!-- theme color file -->
    <link rel="stylesheet" href="{{ theme_asset('css/colors/' . option('dt_theme_color', 'default') . '.css') }}?v={{ time() }}">

    @if ($current_local['direction'] == 'ltr')
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap.ltr.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap.min.css') }}">
    @endif

    @if (config('app.debug'))
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/bootstrap-rtl.min.css') }}">
        <!-- Plugins -->
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ theme_asset('css/vendor/jquery.horizontalmenu.css') }}">
        <link rel="stylesheet" href="{{ theme_asset('js/plugins/toastr/toastr.css') }}">
        <link rel="manifest" href="{{asset('manifest.json')}}" />
        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ theme_asset('css/main.css') }}?v=20">
        <link rel="stylesheet" href="{{ theme_asset('css/styles.css') }}?v=24">
        <link rel="stylesheet" href="{{ theme_asset('css/custom.css') }}?v=1">
        <!-- endinject -->

    @else
        <!-- All Css Files -->
        <link rel="stylesheet" href="{{ mix('css/all.css', config('front.mainfest_path')) }}">
    @endif

    @if ($current_local['direction'] == 'ltr')
        <link rel="stylesheet" href="{{ theme_asset('css/ltr.css') }}?v=2">
    @endif

    @stack('styles')

    {!! option('info_header_codes') !!}
</head>

<body>
<div class="wrapper @yield('wrapper-classes')">


    <!-- Start header -->
    <header class="main-header dt-sl">

        <!-- Start topbar -->
        <div class="container main-container">
            <div class="topbar dt-sl">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo-area float-right">
                            <a href="{{ route('front.index') }}">
                                <img data-src="{{ option('info_logo', theme_asset('img/logo.png')) }}" alt="{{ option('info_site_title', 'فن وب') }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 hidden-sm">
                        <div class="search-area dt-sl">
                            <form id="search-form" action="{{ route('front.products.search') }}" class="search">
                                <input type="text" name="q" value="{{ request('q') }}" id="search-input" autocomplete="off" placeholder="{{ trans('front::messages.header.Search-for-product') }}">
                                <button type="submit"><img data-src="{{ theme_asset('img/theme/search.png') }}" alt="search button"></button>
                                <button id="close-search-result" class="close-search-result" type="button"><i class="mdi mdi-close"></i></button>
                                <div class="search-result p-0" id="search-result">
                                    <ul>

                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-8 topbar-left">
                        @include('front::partials.user-menu')
                    </div>
                </div>
            </div>
        </div>
        <!-- End topbar -->

        <!-- Start bottom-header -->
        <div class="bottom-header dt-sl mb-sm-bottom-header">
            <div class="container main-container">
                <!-- Start Main-Menu -->
                @include('front::partials.menu.menu')
                <!-- End Main-Menu -->
            </div>
        </div>
        <!-- End bottom-header -->
    </header>
    <!-- End header -->


    @yield('content')

    @include('front::partials.footer')
</div>

<audio id="alert-sound" src="{{ asset('back/app-assets/sounds/notification.ogg') }}" preload="auto"></audio>

<script>
    var BASE_URL = "{{ route('front.index') }}";
    var IS_RTL = {{ $current_local['direction'] == 'rtl' ? 1 : 0 }};
</script>

@if (config('app.debug'))
    <!-- Core JS Files -->
    <script src="{{ theme_asset('js/vendor/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/bootstrap.min.js') }}"></script>
    <!-- Plugins -->
    <script src="{{ theme_asset('js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/jquery.horizontalmenu.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/theia-sticky-sidebar.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/jquery.lazyloadxt.min.js') }}"></script>

    <script src="{{ theme_asset("js/plugins/jquery.blockUI.js") }}"></script>
    <script src="{{ theme_asset("js/plugins/sweetalert2.all.min.js") }}"></script>
    <script src="{{ theme_asset("js/plugins/toastr/toastr.min.js") }}"></script>

    <!-- Main JS File -->
    <script src="{{ theme_asset('js/main.js') }}?v=4"></script>
    <script src="{{ theme_asset('js/custom.js') }}"></script>
    <script src="{{ theme_asset("js/scripts.js") }}?v=11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>


@else
    <!-- All JS Files -->
    <script src="{{ mix('js/all.js', config('front.mainfest_path')) }}"></script>
@endif
@stack('plugin-scripts')
@stack('scripts')

@if ($current_local['direction'] == 'ltr')
    <script src="{{ theme_asset('js/ltr.js') }}"></script>
@endif

@toastr_render

{!! option('info_scripts') !!}
<!-- endinject -->

@if(Auth::check())
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('inbox-user-{{Auth::id()}}');
        channel.bind('send-message-user', function(data) {
            var notifications_count=$('.front-dropdown-notification .dropdown-header .notifications-count').attr('data-count');
            notifications_count=parseInt(notifications_count)+parseInt(1)
            $('.front-dropdown-notification .notifications-count').text(notifications_count);
            $('.front-dropdown-notification .dropdown-header .notifications-count').attr('data-count',notifications_count);
            var audio = document.getElementById("alert-sound");
            audio.play();


            $('.front-dropdown-notification .scrollable-container').append(` <a class="d-flex justify-content-between" href="{{ route('front.user.notifications.index') }}">
                    <div class="media d-flex align-items-start">
                        <div class="media-left"><i class="mdi mdi-comment-outline font-medium-5 primary"></i></div>
                        <div class="media-body">
                            <h6 class="primary media-heading">${data.message.title}</h6><small
                            class="notification-text">${data.message.description}</small>
                        </div><small>
                        <time class="media-meta">${data.message.created_at}</time></small>
                    </div>
                </a>`)

        });
    </script>

    <script>
        $(document).ready(function() {
            var url = "{{option('social_instagram')}}"; // لینک مورد نظر برای تولید QR code
            $('#qrcode').qrcode({
                text: url,
                width: 60,
                height: 60
            });
            var urlTelegram = "{{option('social_telegram')}}"; // لینک مورد نظر برای تولید QR code
            $('#qrcodeTelegram').qrcode({
                text: urlTelegram,
                width: 60,
                height: 60
            });

            var urlEita = "{{option('social_eita')}}"; // لینک مورد نظر برای تولید QR code
            $('#qrcodeEita').qrcode({
                text: urlEita,
                width: 60,
                height: 60
            });
        });
    </script>
@endif

</body>

</html>
