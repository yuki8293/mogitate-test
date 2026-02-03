<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mogitate</title>

    {{-- reset → common の順 --}}
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    {{-- ページ個別CSS --}}
    @yield('css')

</head>

<body>
    <header class="header">
        <h1 class="logo">mogitate</h1> <!-- ここが共通 -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; Mogitate</p>
    </footer>
</body>

</html>