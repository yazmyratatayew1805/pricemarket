<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{isset($title) ? $title . ' | ' : '' }}{{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@800&amp;family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-TileColor" content="#d82827">
        <meta name="theme-color" content="#ffffff">
    </head>

    <body class="text-black bg-gray-100">
        <header class="sticky top-0 mx-auto max-w-6xl px-8 py-6 flex justify-between items-center bg-white border-b-2 border-gray-100">
            <a href="/" class="flex items-center">
                <x-logo class="w-8 h-8 mr-4"/>
                <span class="font-display font-black uppercase text-xl tracking-wider">Laravel Shop</span>
            </a>
            <nav>
                <ul class="flex space-x-6">
                    @auth
                        <li><a class="hover:text-red-500 {{$title == 'Products' ? 'font-bold' : ''}}" href="{{ action(\App\Http\Controllers\Products\ProductIndexController::class) }}">Products</a></li>
                        <li><a class="hover:text-red-500 {{$title == 'My Orders' ? 'font-bold' : ''}}" href="{{ action(\App\Http\Controllers\Orders\OrderIndexController::class) }}">My Orders</a></li>
                        <li><a class="hover:text-red-500 {{$title == 'My Cart' ? 'font-bold' : ''}}" href="{{ action(\App\Http\Controllers\Cart\CartDetailController::class) }}">My Cart</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                                <button class="inline hover:text-red-500">
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a class="hover:text-red-500" href="{{ route('login') }}">Log in</a></li>
                        <li><a class="hover:text-red-500" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </nav>
        </header>

        <main class="mx-auto max-w-6xl px-8 py-16 bg-white">
            @isset($breadcrumb)
                {{ $breadcrumb }}
            @else
                <h1 class="mb-12 font-display text-4xl">{{ $title ?? '' }}</h1>
            @endisset
            {{ $slot }}
        </main>

        <footer class="mx-auto max-w-6xl px-8 py-16 text-sm text-center text-gray-500">
            Laravel Shop
        </footer>
    </body>
</html>
