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
    <body class="font-nunito">
        <div class="flex h-screen w-screen">
            <div class="w-6/12 flex">
                <div class="m-auto w-96">
                    <div class="mb-3">
                        <span class="text-4xl text-secondary font-extrabold">SI SABAR</span>
                    </div>
                    <div class="mb-12">
                        <span class="text-xl text-gray-600">Selamat datang! Gunakan akun Anda untuk masuk</span>
                    </div>
                    <div class="mb-3">
                        <input type="text" placeholder="Username" class="text-base w-full py-3 px-5 border-2 border-gray-300 rounded-md focus:border-secondary">
                    </div>
                    <div class="mb-8">
                        <input type="password" placeholder="Password" class="text-base w-full py-3 px-5 border-2 border-gray-300 rounded-md focus:border-secondary">
                    </div>
                    <div>
                        <button class="text-2xl text-white rounded-md bg-primary w-full py-2 font-bold hover:opacity-75">
                            Login
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-6/12 flex bg-secondary">
                <img src="{{ asset('/images/illustrations/people-with-computer.svg') }}" width="444px" class="m-auto">
            </div>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>
</html>