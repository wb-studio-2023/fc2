<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <form method="POST" action="{{ route('member.login') }}">
        @csrf
        <div class="p-3">
            @error('auth')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3">
                &#x26A0; {{ $message }}
            </div>
            @enderror
            <label class="block">メールアドレス</label>
            <input class="border rounded mb-3 px-2 py-1" type="text" name="email">
            <label class="block">パスワード</label>
            <input class="border rounded mb-3 px-2 py-1" type="password" name="password">
            <inpt type="hidden" name="guard" value="member">
            <br>
            <button class="bg-blue-500 text-white rounded px-3 py-2" type="submit">ログイン</button>
        </div>
    </form>
</body>
</html>