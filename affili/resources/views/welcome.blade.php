<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    </head>
    <body class="antialiased">
        <a href="{{ route('administrator.showLoginForm') }}">管理画面へのログインフォーム（仮）</a>
        @auth('member')
            <a href="">aaaaaaaaaaaa</a>
        @else
            <a href="{{ route('member.login') }}">LINE login</a>
        @endauth
    </body>
</html>
