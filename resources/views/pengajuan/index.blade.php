@extends('layouts.page')

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">Pengajuan</span>
            </a>
        </div>
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="text-lg font-semibold" data-modal-toggle="addModal">Tambah Pengajuan</span>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Kode</th>
                    <th class="py-4 px-6">Tgl Pengajuan</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Qty</th>
                    <th class="py-4 px-6">Cabang</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white">
                    <td class="py-4 px-6">PGJ-0001</td>
                    <td class="py-4 px-6">31 Nov 2022</td>
                    <td class="py-4 px-6">Biskuit Marrie Regal</td>
                    <td class="py-4 px-6">10</td>
                    <td class="py-4 px-6">Bandung</td>
                    <td class="py-4 px-6">Pending</td>
                    <td class="py-4 px-6 text-center">
                        <i data-modal-toggle="detailModal" class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-secondary"></i>
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
                        TAMBAH PENGAJUAN
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Kode Pengajuan<span class="text-red-600">*</span></label>
                        <input type="text" class="kode w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan kode">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Tanggal Pengajuan<span class="text-red-600">*</span></label>
                        <input type="date" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Pilih tanggal">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Cabang<span class="text-red-600">*</span></label>
                        <input type="text" class="telepon w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan cabang">
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Tipe<span class="text-red-600">*</span></label>
                        <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Pilih tipe">
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <label class="text-sm font-semibold">Daftar Produk</label>
                    <hr class="border mt-1 mb-4" style="">
                    <div  class="grid grid-cols-12 gap-x-4 items-end mb-6">
                        <div class="col-span-7">
                            <label class="text-sm font-semibold mb-3">Produk<span class="text-red-600">*</span></label>
                            <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Pilih produk">
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm font-semibold mb-3">Qty<span class="text-red-600">*</span></label>
                            <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="0">
                        </div>
                        <div class="col-span-2">
                            <button class="bg-green-400 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer">+</button>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <label class="text-sm font-semibold mb-3">Keterangan<span class="text-red-600">*</span></label>
                    <textarea class="alamat w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan keterangan" rows="2"></textarea>
                </div>
                <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                    <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        DETAIL PENGAJUAN
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="detailModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-12 gap-x-4 gap-y-2">
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Kode Pengajuan</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">PGJ-0001</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Tanggal Pengajuan</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">10 Desember 2022</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Cabang</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">Griya Moh. Toha</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Tipe</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">Order</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Keterangan</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">keterangan order ini adalah untuk pemasaran</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Status</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">Pending</label>
                        </div>
                    </div>

                    <hr class="my-5 border-gray-300">

                    <div>
                        <div class="text-sm font-bold mb-4">Daftar Produk</div>
                        <div class="rounded-xl overflow-x-auto shadow-sm border border-gray-50 mb-8">
                            <table class="w-full text-left">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th class="py-4 px-6">Produk</th>
                                        <th class="py-4 px-6">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white">
                                        <td class="py-4 px-6">Chitato</td>
                                        <td class="py-4 px-6">10</td>
                                    </tr>
                                    <tr class="bg-white">
                                        <td class="py-4 px-6">Sabun Cair Lifebuoy 450ml</td>
                                        <td class="py-4 px-6">5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button type="button" class="text-white w-28 bg-red-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reject</button>
                    <button type="button" class="text-white w-28 bg-green-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approve</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        
    </script>
@endsection