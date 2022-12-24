@extends('layouts.page')

@section('content')
    <div class="grid md:grid-rows-4 md:grid-cols-3 gap-7 mt-16">
        @role("admin|md|supplier")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/produk')">
            <i class="mdi mdi-archive text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Produk</span>
        </div>
        @endrole
        @role("admin|md")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/supplier')">
            <i class="mdi mdi-account-group text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Supplier</span>
        </div>
        @endrole
        @role("admin|md|admin-cabang|supplier")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/transaksi')">
            <i class="mdi mdi-clipboard-text text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Transaksi</span>
        </div>
        @endrole
        @role("admin|md")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/kategori-produk')">
            <i class="mdi mdi-folder text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Kategori</span>
        </div>
        @endrole
        @role("admin|md")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/cabang')">
            <i class="mdi mdi-home-assistant text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Cabang</span>
        </div>
        @endrole
        @role("admin|md")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/pengguna')">
            <i class="mdi mdi-account-box text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Pengguna</span>
        </div>
        @endrole
        @role("admin|md|admin-cabang")
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/pengajuan')">
            <i class="mdi mdi-receipt text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Pengajuan</span>
        </div>
        @endrole
        <div class="py-6 px-12 rounded-lg bg-secondary flex flex-row hover:opacity-75 cursor-pointer" onclick="goToMenu('/pengajuan')">
            <i class="mdi mdi-history text-purple-100 text-6xl my-auto"></i>
            <span class="text-3xl text-white font-bold my-auto ml-6">Log Barang</span>
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
