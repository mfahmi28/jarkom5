<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Si Sabar - Sistem Pemesanan Barang</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">

        <style>
            html, body {
                min-height: 100vh;
            }
        </style>
    </head>
    <body class="font-nunito bg-indigo-50">
        <div class="px-40 bg-white py-3 shadow-md flex flex-row">
            <div class="flex">
                <div><i class="mdi mdi-account-circle text-4xl text-primary"></i></div>
                <div class="flex flex-col ml-3">
                    <span class="text-base font-bold">Wahyu Rifaldi</span>
                    <span class="text-sm text-gray-400">Admin</span>
                </div>
            </div>
            <div class="ml-auto flex">
                <i class="mdi mdi-dots-vertical text-3xl text-gray-600 my-auto"></i>
            </div>
        </div>
        
        <div class="mx-40 mt-24">
            @yield('content')
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>
</html>