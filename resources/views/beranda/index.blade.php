@extends('layouts.page')

@section('content')
    <div class="grid grid-rows-4 grid-cols-3 gap-7 mt-16">
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/produk')">
            <i class="mdi mdi-archive text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Produk</span>
        </div>
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/supplier')">
            <i class="mdi mdi-account-group text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Supplier</span>
        </div>
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer">
            <i class="mdi mdi-clipboard-text text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Transaksi</span>
        </div>
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/kategori-produk')">
            <i class="mdi mdi-folder text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Kategori</span>
        </div>
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/cabang')">
            <i class="mdi mdi-home-assistant text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Cabang</span>
        </div>
        @role("admin")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/pengguna')">
            <i class="mdi mdi-account-box text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Pengguna</span>
        </div>
        @endrole
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer">
            <i class="mdi mdi-receipt text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Pengajuan</span>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const goToMenu = (url) => {
            location.href = url
        }
    </script>
@endsection
