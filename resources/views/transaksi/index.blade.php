@extends('layouts.page')

@section('style')
    <style>
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
@endsection

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">Transaksi</span>
            </a>
        </div>
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="toggle-modal text-lg font-semibold" data-modal="addModal">Tambah Transaksi</span>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Kode</th>
                    <th class="py-4 px-6">Tgl Pesan</th>
                    <th class="py-4 px-6">Tgl Pengiriman</th>
                    <th class="py-4 px-6">Pemesan</th>
                    <th class="py-4 px-6">Supplier</th>
                    <th class="py-4 px-6">Tujuan Cabang</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @if(!empty($transactions))
                    @foreach ($transactions as $transaction)
                    <tr class="bg-white">
                        <td class="py-4 px-6">{{$transaction->order_code}}</td>
                        <td class="py-4 px-6">{{$transaction->created_at}}</td>
                        <td class="py-4 px-6">{{$transaction->estimated_date}}</td>
                        <td class="py-4 px-6">{{$transaction->maker->name}}</td>
                        <td class="py-4 px-6">{{$transaction->supplier->nama}}</td>
                        <td class="py-4 px-6">{{$transaction->cabang->nama}}</td>
                        <td class="py-4 px-6">{{$transaction->status_name}}</td>
                        <td class="py-4 px-6 text-center">
                            <i data-modal-toggle="detailModal" class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-secondary"></i>
                            <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600"></i>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr class="bg-white">
                        <td class="py-4 px-6 text-center" colspan="100%">Tidak Ada Data</td>
                @endif
            </tbody>
        </table>
    </div>

    @include('transaksi.components.add_modal')

    <!-- DETAIL MODAL -->
    <div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        DETAIL TRANSAKSI
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="detailModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 modal-form">
                    <div class="grid grid-cols-12 gap-x-4 gap-y-2">
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Order Number</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">ORD-0001</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Supplier</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">PT. Indofood Makmur</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Est. Tanggal Pengiriman</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">31 Nov 2022</label>
                        </div>
                        <div class="col-span-5">
                            <label class="text-sm font-bold">Tujuan Cabang</label>
                        </div>
                        <div class="col-span-7">
                            <label class="text-sm font-semibold">Bandung</label>
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
                        <div class="bg-purple-100 border border-secondary p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-semibold">Total Harga Produk</label>
                                <div class="text-sm font-semibold"></div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-semibold">Pajak</label>
                                <div class="text-sm font-semibold">Rp1.000</div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-semibold">Sub Total</label>
                                <div class="text-sm font-semibold">Rp11.000</div>
                            </div>
                            <hr class="my-4 border-secondary">
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-semibold">Total</label>
                                <div class="text-sm font-semibold">Rp11.000</div>
                            </div>
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
        const route = "{{ url('') }}";

        const addTransaksi = () => {
            showLoadingScreen(true)
            let array = $("#create_form").serializeArray();
            let objects = Object.fromEntries(
                array.map((item) => [item.name, item.value])
            );
            $.ajax({
                type: 'POST',
                url: '/transaksi',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...objects,
                },
                success: function(response) {
                    showLoadingScreen(false)

                    if(response.status == 'OK') {
                        location.reload()
                    } else {
                        alert(response.message)
                    }
                },
                error: function() {
                    showLoadingScreen(false)

                    alert('Terjadi Kesalahan! Silahkan Ulangi')
                }
            })
        }

        const createProdukTemplate = (pid, pname, qty, price = 0) => {
            return `
                <div class="create_new_produk grid grid-cols-12 gap-x-4 items-end mb-6" data-produk="${pid}">
                    <div class="col-span-7">
                        <label class="text-sm font-semibold mb-3">Produk<span class="text-red-600">*</span></label>
                        <input class="produk_price" type="hidden" value="${price}">
                        <input type="hidden" name="produk_list[${pid}][id]" value="${pid}">
                        <input type="text" class="produk_id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" value="${pname}" disabled>
                    </div>
                    <div class="col-span-3">
                        <label class="text-sm font-semibold mb-3">Qty<span class="text-red-600">*</span></label>
                        <input type="number" name="produk_list[${pid}][qty]" class="qty w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" value="${qty}" placeholder="0">
                    </div>
                    <div class="col-span-2">
                        <button type="button" class="remove_produk bg-red-500 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer" data-produk="${pid}">×</button>
                    </div>
                </div>
            `;
        };
    </script>
    <script src="{{ asset('js/pages/transaksi.js') }}"></script>
@endsection
