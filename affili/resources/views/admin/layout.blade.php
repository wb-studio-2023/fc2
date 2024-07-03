<!DOCTYPE html>
    <head>
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('css/admin/common.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        @yield('css')
        @yield('js')
        @yield('component')
    </head>
    <body>
        <main>
            @include('admin.partical.sidenavi')
            @include('admin.partical.headnavi')
            <div id="content">
                @yield('content')
            </div>
        </main>
    </body>
</html>