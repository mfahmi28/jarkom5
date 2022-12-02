@extends('layouts.page')

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">Cabang</span>
            </a>
        </div>
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="text-lg font-semibold" data-modal-toggle="addModal">Tambah Cabang</span>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white">
                    <td class="py-4 px-6">PT. Cipta Abadi</td>
                    <td class="py-4 px-6">Jl. Soekarno Hatta no.17</td>
                    <td class="py-4 px-6 text-center">
                        <i class="mdi mdi-pencil text-lg cursor-pointer hover:opacity-75 text-yellow-300 mr-5"></i>
                        <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600"></i>
                    </td>
                </tr>
                <tr class="bg-purple-100">
                    <td class="py-4 px-6">PT. Cipta Abadi</td>
                    <td class="py-4 px-6">Jl. Soekarno Hatta no.17</td>
                    <td class="py-4 px-6 text-center">
                        <i class="mdi mdi-pencil text-lg cursor-pointer hover:opacity-75 text-yellow-300 mr-5"></i>
                        <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ADD MODAL -->
    <div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        TAMBAH CABANG
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Nama<span class="text-red-600">*</span></label>
                        <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan nama">
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Alamat<span class="text-red-600">*</span></label>
                        <textarea class="keterangan w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan alamat" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                    <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection