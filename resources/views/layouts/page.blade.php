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

        @yield('style')
    </head>
    <body class="font-nunito bg-purple-50">
        <div class="px-40 bg-white py-3 shadow-md flex flex-row sticky top-0 z-10">
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
        
        <div class="mx-40 my-10">
            @yield('content')
        </div>

        <div id="loadingScreen" class="absolute top-0 left-0 w-screen h-screen bg-black bg-opacity-50 hidden" style="z-index: 9999;">
            <div class="m-auto w-12 h-12 rounded-full border-4 border-gray-300 animate-spin" style="border-top-color: #3C5AC2;"></div>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>

    <script>
        const showLoadingScreen = (isShow=false) => {
            if(isShow) {
                $('#loadingScreen').addClass('flex')
                $('#loadingScreen').removeClass('hidden')
            } else {
                $('#loadingScreen').removeClass('flex')
                $('#loadingScreen').addClass('hidden')
            }
        }
    </script>

    @yield('javascript')
</html>