<!DOCTYPE html>
    <head>
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('css/front/pc/app.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="module" src="{{ mix('js/front/sp/app.js') }}"></script>
        <script src="{{ mix('js/front/pc/common.js') }}"></script>
        @yield('css')
        @yield('js')
        @yield('component')
    </head>
    <body>
        <header>
            @include('front.pc.partical.header')
        </header>
        <main>
            <div id="leftNavi">
                @include('front.pc.partical.leftNavi')
            </div>
            <div id="contentsWrap">
                @yield('content')
            </div>
            <div id="rightNavi">
                @include('front.pc.partical.rightNavi')
            </div>
        </main>
        <footer>
            @include('front.pc.partical.footer')
        </footer>
    </body>
</html>