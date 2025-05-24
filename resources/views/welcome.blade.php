<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Test</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form/style.css') }}">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="{{route('product.index')}}">Управление товарами</a></li>
            <li><a href="{{route('order.index')}}">Управление заказами</a></li>
        </ul>
    </nav>
</header>

<main>
    @yield('content')
</main>
</body>
</html>

