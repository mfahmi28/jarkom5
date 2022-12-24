@extends('layouts.page')

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">Log Barang</span>
            </a>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Kode Transaksi</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Qty</th>
                    <th class="py-4 px-6">Cabang</th>
                    <th class="py-4 px-6">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(sizeof($transaksiProdukLogList))
                    @foreach($transaksiProdukLogList as $idx => $transaksiProdukLog)
                        <tr class="{{ $idx%2 ? 'bg-purple-100' : 'bg-white' }}">
                            <td class="py-4 px-6">{{ $transaksiProdukLog->transaksi_kode }}</td>
                            <td class="py-4 px-6">{{ $transaksiProdukLog->produk }}</td>
                            <td class="py-4 px-6">{{ $transaksiProdukLog->qty }}</td>
                            <td class="py-4 px-6">{{ $transaksiProdukLog->cabang_nama }}</td>
                            <td class="py-4 px-6">
                                @if($transaksiProdukLog->status == 'STOK')
                                    <span class="text-green-500 text-sm">
                                        <i class="mdi mdi-arrow-down-bold-circle text-sm mr-1"></i> Stok
                                    </span>
                                @elseif($transaksiProdukLog->status == 'RETUR')
                                    <span class="text-red-500 text-sm">
                                        <i class="mdi mdi-arrow-up-bold-circle text-sm mr-1"></i> Butuh Diretur
                                    </span>
                                @elseif($transaksiProdukLog->status == 'RETUR_PROSES')
                                    <span class="text-red-500 text-sm">
                                        <i class="mdi mdi-arrow-up-bold-circle text-sm mr-1"></i> Proses Retur
                                    </span>
                                @elseif($transaksiProdukLog->status == 'RETUR_STOK')
                                    <span class="text-green-500 text-sm">
                                        <i class="mdi mdi-arrow-down-bold-circle text-sm mr-1"></i> Stok (Berhasil Retur)
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="bg-white">
                        <td class="py-4 px-6 text-center" colspan="100%">Tidak Ada Data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $transaksiProdukLogList->links('pagination::tailwind') }}
    </div>
@endsection

@section('javascript')

@endsection