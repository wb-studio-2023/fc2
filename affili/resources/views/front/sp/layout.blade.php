<!DOCTYPE html>
    <head>
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('css/front/sp/app.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="module" src="{{ mix('js/front/sp/app.js') }}"></script>
        @yield('css')
        @yield('js')
        @yield('component')
    </head>
    <body>
        <header>
            @include('front.sp.partical.header')
            <div id="menu">
                @include('front.sp.partical.menu')
            </div>
        </header>
        <main>
            <div id="content">
                @yield('content')
            </div>
        </main>
        <footer>
            @include('front.sp.partical.footer')
        </footer>
    </body>
</html>