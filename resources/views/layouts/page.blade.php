<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Si Sabar - Sistem Pemesanan Barang</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}"/>

        <style>
            html, body {
                min-height: 100vh;
            }

            .select2-container {
                width: 100% !important;
            }

            .select2-container .select2-selection--single {
                height: 44px;
                background: #f9fafb;
                border: unset;
                border-radius: 0.5em;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 44px;
                padding-left: 12px;
                font-size: 14px;
                color: #000;
                font-weight: 600;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 44px;
                top: 0;
                right: 0;
                margin-right: 12px;
            }

            .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: #6b7280;
            }

            .select2-container--open .select2-dropdown--below {
                border-top: 1px solid #aaa;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>

        @yield('style')
    </head>
    <body class="font-nunito bg-purple-50">
        <div class="md:px-40 px-3 bg-white py-3 shadow-md flex flex-row sticky top-0 z-10">
            <div class="flex">
                <div><i class="mdi mdi-account-circle text-4xl text-primary"></i></div>
                <div class="flex flex-col ml-3">
                    <span class="text-base font-bold">{{ \Auth::user()->name }}</span>
                    <span class="text-sm text-gray-400">{{ \Auth::user()->role->name }}</span>
                </div>
            </div>
            <div class="ml-auto flex">
                <button id="dropdownDefault" data-dropdown-toggle="dropdown" class="" type="button">
                    <i class="mdi mdi-dots-vertical text-3xl text-gray-600 my-auto"></i>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg dark:bg-gray-700">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                        <li>
                            <a href="{{ route('logout') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="md:mx-40 mx-3 py-10">
            @yield('content')
        </div>

        <div id="loadingScreen" class="absolute top-0 left-0 w-screen h-screen bg-black bg-opacity-50 hidden" style="z-index: 9999;">
            <div class="m-auto w-12 h-12 rounded-full border-4 border-gray-300 animate-spin" style="border-top-color: #3C5AC2;"></div>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>

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
