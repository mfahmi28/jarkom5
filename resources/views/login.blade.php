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
        <div class="flex h-screen w-screen bg-purple-50">
            <div class="flex m-auto rounded-3xl relative overflow-x-auto shadow-lg">
                <div class="w-6/12 flex p-16 bg-white">
                    <div class="m-auto w-96">
                        <div class="mb-3">
                            <span class="text-4xl text-primary font-extrabold">SI SABAR</span>
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
                            <button class="text-2xl text-white rounded-md bg-primary w-full py-2 font-bold hover:opacity-75" onclick="goToMenu('/beranda')">
                                Login
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-6/12 flex p-16 bg-secondary">
                    <img src="{{ asset('/images/illustrations/people-with-goods.svg') }}" width="364px" class="m-auto">
                </div>
            </div>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>
    <script>
        const goToMenu = (url) => {
            location.href = url
        }
    </script>
</html>