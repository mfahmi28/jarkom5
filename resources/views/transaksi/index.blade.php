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
        @role('admin')
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="text-lg font-semibold" onclick="showTransactionCreate()">Tambah Transaksi</span>
        </div>
        @endrole
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
                    <th class="py-4 px-6" width="140px">Status</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(sizeof($transactions))
                    @foreach ($transactions as $idx => $transaction)
                    <tr class="{{ $idx%2 ? 'bg-purple-100' : 'bg-white' }}">
                        <td class="py-4 px-6">{{ $transaction->order_code }}</td>
                        <td class="py-4 px-6">{{ $transaction->created_at }}</td>
                        <td class="py-4 px-6">{{ $transaction->estimated_date }}</td>
                        <td class="py-4 px-6">{{ $transaction->maker->name }}</td>
                        <td class="py-4 px-6">{{ $transaction->supplier->nama }}</td>
                        <td class="py-4 px-6">{{ $transaction->cabang->nama }}</td>
                        <td class="py-4 px-6">
                            @if($transaction->status == 0)
                                <span class="text-gray-500 text-sm">
                                    <i class="mdi mdi-clock text-sm mr-1"></i> {{ $transaction->status_name }}
                                </span>
                            @elseif($transaction->status == 1)
                                <span class="text-green-500 text-sm">
                                    <i class="mdi mdi-check-circle text-sm mr-1"></i> {{ $transaction->status_name }}
                                </span>
                            @elseif($transaction->status == 2)
                                <span class="text-red-500 text-sm">
                                    <i class="mdi mdi-close-circle text-sm mr-1"></i> {{ $transaction->status_name }}
                                </span>
                            @elseif($transaction->status == 3)
                                <span class="text-blue-500 text-sm">
                                    <i class="mdi mdi-arrow-up-bold-circle text-sm mr-1"></i> {{ $transaction->status_name }}
                                </span>
                            @elseif($transaction->status == 4)
                                <span class="text-orange-500 text-sm">
                                    <i class="mdi mdi-arrow-down-bold-circle text-sm mr-1"></i> {{ $transaction->status_name }}
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <i onclick="showTransactionDetail({{ $transaction->id }})" class="mdi mdi-file-document text-lg cursor-pointer hover:opacity-75 text-secondary"></i>
                            @role('admin')
                            <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600 ml-5" onclick="applyTransaksi({{ $transaction->id }}, 'delete')"></i>
                            @endrole
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

    @include('transaksi.components.add_modal')
    @include('transaksi.components.detail_modal')

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
                        <input type="number"  onchange="calculateTotal()" name="produk_list[${pid}][qty]" class="qty w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" value="${qty}" placeholder="0">
                    </div>
                    <div class="col-span-2">
                        <button type="button" class="remove_produk bg-red-500 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer" data-produk="${pid}">×</button>
                    </div>
                </div>
            `;
        };

        const listProdukTemplate = (name, qty, bgColor, trxProdukId) => {
            return `
                <tr class="${bgColor}">
                    <td class="py-4 px-6">${name}</td>
                    <td class="py-4 px-6">${qty}</td>
                    <td class="py-4 px-6 retur-field">
                        <input type="hidden" class="trx-produk-id" value="${trxProdukId}">
                        <input type="number" class="qty-retur text-sm font-semibold p-3 bg-gray-50 rounded-lg border border-secondary" placeholder="0" min="0" max="${qty}" value="0">
                    </td>
                </tr>`;
        }

        const applyTransaksi = (id, action) => {
            let modal = $('#detailModal'),
                produkReturList = []
            
            if(action == 'recieve') {
                modal.find('#detail_list_produks .retur-field').each(function() {
                    let trxProdukId = $(this).find('.trx-produk-id').val(),
                        qtyRetur = $(this).find('.qty-retur').val()

                    produkReturList.push({
                        transaksi_produk_id: trxProdukId,
                        qty_retur: qtyRetur != '' ? qtyRetur : 0
                    })
                })
            }

            showLoadingScreen(true)

            $.ajax({
                type: 'POST',
                url: `/transaksi/${id}/${action}`,
                data: {
                    _token: '{{ csrf_token() }}',
                    produk_retur_list: produkReturList
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
    </script>
    <script src="{{ asset('js/pages/transaksi.js') }}"></script>
@endsection
