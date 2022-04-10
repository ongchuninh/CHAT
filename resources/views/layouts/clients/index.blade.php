<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link href="/uploads/images/favicon.png" rel="shortcut icon" type="image/png">
    @yield('seo')
    <link rel="stylesheet" href="/clients/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/clients/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/clients/css/owl.theme.default.min.css" />
    <link rel="stylesheet" media="screen and (max-device-width: 900px)" href="/clients/css/swiper.min.css"/>
    <link rel="stylesheet" href="/clients/css/style.css" />
    @yield('css')
</head>

<body>
    @include('layouts.clients.header')
    <main>
        @yield('content')
        @include('layouts.clients.contact')
    </main>
    @include('layouts.clients.footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/clients/js/bootstrap.min.js"></script>
    <script src="/clients/js/owl.carousel.min.js"></script>
    <script src="/clients/js/swiper.min.js"></script>
    <script>
        var url_locale = '{{ route('api.changeLanguage') }}';
        console.log(window.location)
    </script>
    <script src="/clients/js/main.js"></script>
    @yield('js')
    <script>
        $(document).ready(function(){
            $('body').on('change', '#list-language', function () {
                $.ajax({
                    url: url_locale,
                    method: 'get',
                    dataType: 'json',
                    data: {
                        
                        lang: $(this).val()
                    },
                    success: function (res) {
                        window.location.reload();

                    }
                })
            })
        })
    </script>
</body>

</html>