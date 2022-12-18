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
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Tipe</th>
                    <th class="py-4 px-6">Pembuat</th>
                    <th class="py-4 px-6">Cabang</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(count($pengajuanList) > 0)
                    @foreach($pengajuanList as $idx => $pengajuan)
                    <tr class="{{ $idx%2 ? 'bg-purple-100' : 'bg-white' }}">
                        <td class="py-4 px-6">{{ $pengajuan->kode }}</td>
                        <td class="py-4 px-6">{{ $pengajuan->tanggal }}</td>
                        <td class="py-4 px-6">{{ $pengajuan->tipe }}</td>
                        <td class="py-4 px-6">{{ $pengajuan->user_created }}</td>
                        <td class="py-4 px-6">{{ $pengajuan->cabang }}</td>
                        <td class="py-4 px-6">
                            @if($pengajuan->status == 'APPROVED')
                                <span class="text-green-500 text-sm">
                                    <i class="mdi mdi-check-circle text-sm mr-1"></i> DISETUJUI
                                </span>
                            @elseif($pengajuan->status == 'REJECTED')
                                <span class="text-red-500 text-sm">
                                    <i class="mdi mdi-close-circle text-sm mr-1"></i> DITOLAK
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">
                                    <i class="mdi mdi-clock text-sm mr-1"></i> PENDING
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <i class="mdi mdi-file-document text-lg cursor-pointer hover:opacity-75 text-blue-600 mr-5" onclick="showPengajuanDetail('{{ $pengajuan->kode }}')"></i>
                            @if($pengajuan->status == 'PENDING')
                                <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600" onclick="deletePengajuan('{{ $pengajuan->kode }}')"></i>
                            @else
                                <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-gray-400"></i>
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
        {{ $pagination }}
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
                        <label class="text-sm font-semibold mb-3">Tanggal Pengajuan<span class="text-red-600">*</span></label>
                        <input type="date" class="tanggal w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Pilih tanggal">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Cabang<span class="text-red-600">*</span></labellabel>
                        <select class="cabang-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" {{ !empty(Auth::user()->cabang_id) ? 'disabled' : '' }}>
                            <option value="" selected disabled>-</option>
                            @foreach($cabangList as $cabang)
                            <option value="{{ $cabang->id }}" {{ $cabang->id == Auth::user()->cabang_id ? 'selected' : '' }}>[{{ $cabang->kode }}] {{ $cabang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Keterangan</label>
                        <textarea class="keterangan w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <label class="text-base font-semibold">Daftar Produk</label>
                    <hr class="mt-1 mb-4" style="">
                    <div id="produkFields">
                        <div id="produkField0" class="grid grid-cols-12 gap-x-4 items-end mb-6">
                            <div class="col-span-7">
                                <label class="text-sm font-semibold mb-3">Produk<span class="text-red-600">*</span></label>
                                <select class="produk-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                                    <option value="" selected disabled>-</option>
                                    @foreach($produkList as $produk)
                                    <option value="{{ $produk->id }}">[{{ $produk->kode }}] {{ $produk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="text-sm font-semibold mb-3">Qty<span class="text-red-600">*</span></label>
                                <input type="number" class="qty w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="0">
                            </div>
                            <div class="col-span-2">
                                <button class="bg-green-400 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer" onclick="addProdukField()">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                    <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="addPengajuan()">Simpan</button>
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
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal('detail')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-12 gap-x-4 gap-y-2">
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Kode Pengajuan</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold kode">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Tanggal Pengajuan</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold tanggal">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Pengaju</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold pengaju">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Cabang</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold cabang">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Tipe</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold tipe">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Keterangan</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold keterangan">-</label>
                        </div>
                        <div class="col-span-4">
                            <label class="text-sm font-bold">Status</label>
                        </div>
                        <div class="col-span-8">
                            <label class="text-sm font-semibold status">-</label>
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
                                    <!-- JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @role('admin|md')
                <div class="modal-action flex items-center justify-end px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button type="button" class="text-white w-28 bg-red-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="confirmPengajuan('REJECTED')">Reject</button>
                    <button type="button" class="text-white w-28 bg-green-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="confirmPengajuan('APPROVED')">Approve</button>
                </div>
                @endrole
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        let produkFieldIdx = 0,
            detailModal = new Modal(document.getElementById('detailModal'), {})

        const closeModal = (tipe='') => {
            if(tipe == 'detail') {
                detailModal.hide()
            }
        }

        const addProdukField = () => {
            produkFieldIdx += 1

            $('#produkFields').append(`
                <div id="produkField${produkFieldIdx}" class="grid grid-cols-12 gap-x-4 items-end mb-6">
                    <div class="col-span-7">
                        <label class="text-sm font-semibold mb-3">Produk<span class="text-red-600">*</span></label>
                        <select class="produk-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                            <option value="" selected disabled>-</option>
                            @foreach($produkList as $produk)
                            <option value="{{ $produk->id }}">[{{ $produk->kode }}] {{ $produk->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <label class="text-sm font-semibold mb-3">Qty<span class="text-red-600">*</span></label>
                        <input type="number" class="qty w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="0">
                    </div>
                    <div class="col-span-2">
                        <button class="bg-red-400 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer" onclick="removeProdukField(${produkFieldIdx})">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                </div>
            `)
        }

        const removeProdukField = (idx) => {
            $(`#produkField${idx}`).remove()
        }

        const addPengajuan = () => {
            let modal = $('#addModal'),
                tanggal = modal.find('.tanggal').val(),
                cabangId = modal.find('.cabang-id').val(),
                keterangan = modal.find('.keterangan').val(),
                produkList = [],
                isValid = true,
                errorMessage = ''

            if(tanggal == '') {
                return alert('Harap Mengisi Tanggal!')
            } else if(cabangId == '') {
                return alert('Harap Memilih Cabang!')
            }

            modal.find('#produkFields').children().each(function() {
                let produkId = $(this).find('.produk-id').val() ?? '',
                    qty = $(this).find('.qty').val()

                if(produkId == '') {
                    isValid = false
                    errorMessage = 'Harap Memilih Produk!'

                    return false
                } else if(qty == '') {
                    isValid = false
                    errorMessage = 'Harap Mengisi Qty Produk!'

                    return false
                }

                produkList.push({
                    produk_id: produkId,
                    qty: qty
                })
            })

            if(!isValid) {
                return alert(errorMessage)
            }

            showLoadingScreen(true)

            $.ajax({
                type: 'POST',
                url: '',
                data: {
                    _token: '{{ csrf_token() }}',
                    tanggal: tanggal,
                    cabang_id: cabangId,
                    keterangan: keterangan,
                    produk_list: produkList
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

        const showPengajuanDetail = (pengajuanKode) => {
            let modal = $('#detailModal')

            showLoadingScreen(true)

            $.ajax({
                type: 'GET',
                url: '/pengajuan/detail',
                data: {
                    pengajuan_kode: pengajuanKode
                },
                success: function(response) {
                    showLoadingScreen(false)

                    if(response.status == 'OK') {
                        let pengajuanDetail = response.pengajuan_detail,
                            statusLabel = ''

                        if(pengajuanDetail.status == 'APPROVED') {
                            statusLabel = `<span class="text-green-500 text-sm">
                                <i class="mdi mdi-check-circle text-sm mr-1"></i> DISETUJUI
                            </span>`
                        } else if(pengajuanDetail.status == 'REJECTED') {
                            statusLabel = `<span class="text-red-500 text-sm">
                                <i class="mdi mdi-close-circle text-sm mr-1"></i> DITOLAK
                            </span>`
                        } else {
                            statusLabel = `<span class="text-gray-500 text-sm">
                                <i class="mdi mdi-clock text-sm mr-1"></i> PENDING
                            </span>`
                        }
                        
                        modal.find('.kode').html(pengajuanDetail.kode)
                        modal.find('.tanggal').html(pengajuanDetail.tanggal)
                        modal.find('.pengaju').html(pengajuanDetail.user_created)
                        modal.find('.cabang').html(pengajuanDetail.cabang)
                        modal.find('.tipe').html(pengajuanDetail.tipe)
                        modal.find('.keterangan').html(pengajuanDetail.keterangan != '' ? pengajuanDetail.keterangan : '-' )
                        modal.find('.status').html(statusLabel)

                        modal.find('table tbody').html('')
                        pengajuanDetail.produk_list.forEach((produk, idx) => {
                            modal.find('table tbody').append(`
                                <tr class="${idx%2 ? 'bg-purple-100' : 'bg-white'}">
                                    <td class="py-4 px-6">${produk.nama}</td>
                                    <td class="py-4 px-6">${produk.qty}</td>
                                </tr>
                            `)
                        })

                        if(pengajuanDetail.status != 'PENDING') {
                            modal.find('.modal-action').addClass('hidden')
                        } else {
                            modal.find('.modal-action').removeClass('hidden')
                        }

                        detailModal.show()
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

        const deletePengajuan = (pengajuanKode) => {
            if(confirm('Yakin Menghapus Pengajuan Ini?')) {
                showLoadingScreen(true)

                $.ajax({
                    type: 'DELETE',
                    url: '/pengajuan',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pengajuan_kode: pengajuanKode
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
        }

        const confirmPengajuan = (status) => {
            let modal = $('#detailModal'),
                kode = modal.find('.kode').text(),
                messageConfirm = ''

            if(status == 'APPROVED') {
                messageConfirm = 'Yakin Menyetujui Pengajuan Ini?'
            } else if(status == 'REJECTED') {
                messageConfirm = 'Yakin Menolak Pengajuan Ini?'
            }

            showLoadingScreen(true)

            if(confirm(messageConfirm)) {
                $.ajax({
                    type: 'PUT',
                    url: '/pengajuan/status/update',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kode: kode,
                        status: status
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
        }
    </script>
@endsection