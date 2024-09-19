<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <style>
            .quantity{
                text-align: center;
                width: 50px;
                border: none;
                height: 30px;
            }
            .cart{
                display: flex;
            }
            .btn{
                width: 30px;
                height: 30px;
                border: 1px solid blue;
            }
            .btn_cart{
                border: 1px solid green;
                width: 100%;
                height: 30px;
                margin-left: 5px;
            }
            .cart_delete{
                border: 1px solid red;
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        @spladeHead
    </head>
    <body class="font-sans antialiased">
        @splade
    </body>
</html>
