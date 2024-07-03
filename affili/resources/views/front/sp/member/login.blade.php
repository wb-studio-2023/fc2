<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <form method="POST" action="member">
        @csrf
        <div class="p-3">
            <button class="" type="submit"><img src="{{ asset('img/member/btn_login_base.png') }}" alt="LINEログインボタン"></button>
        </div>
    </form>
</body>
</html>