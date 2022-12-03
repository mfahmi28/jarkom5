@extends('layouts.page')

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">Supplier</span>
            </a>
        </div>
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="text-lg font-semibold" data-modal-toggle="addModal">Tambah Supplier</span>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Kode</th>
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Telepon</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(count($supplierList) > 0)
                    @foreach($supplierList as $idx => $supplier)
                    <tr class="{{ $idx%2 ? 'bg-purple-100' : 'bg-white' }}">
                        <td class="py-4 px-6">{{ $supplier->kode }}</td>
                        <td class="py-4 px-6">{{ $supplier->nama }}</td>
                        <td class="py-4 px-6">{{ $supplier->telepon }}</td>
                        <td class="py-4 px-6">{{ $supplier->alamat }}</td>
                        <td class="py-4 px-6 text-center">
                            <i class="mdi mdi-pencil text-lg cursor-pointer hover:opacity-75 text-yellow-300 mr-5" onclick="showSupplierDetail('{{ $supplier->id }}')"></i>
                            <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600" onclick="deleteSupplier('{{ $supplier->id }}')"></i>
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
        {{ $supplierList->links('pagination::tailwind') }}
    </div>

    <!-- ADD MODAL -->
    <div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        TAMBAH SUPPLIER
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Kode<span class="text-red-600">*</span></label>
                        <input type="text" class="kode w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan kode">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Nama<span class="text-red-600">*</span></label>
                        <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan nama">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Telepon<span class="text-red-600">*</span></label>
                        <input type="tel" class="telepon w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan telepon">
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Alamat<span class="text-red-600">*</span></label>
                        <textarea class="alamat w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan alamat" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                    <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="addSupplier()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        EDIT SUPPLIER
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal('edit')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <input type="hidden" class="supplier-id">
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Kode<span class="text-red-600">*</span></label>
                        <input type="text" class="kode w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan kode">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Nama<span class="text-red-600">*</span></label>
                        <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan nama">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Telepon<span class="text-red-600">*</span></label>
                        <input type="tel" class="telepon w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan telepon">
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Alamat<span class="text-red-600">*</span></label>
                        <textarea class="alamat w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan alamat" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button onclick="closeModal('edit')" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                    <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="editSupplier()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        let editModal = new Modal(document.getElementById('editModal'), {})

        const closeModal = (tipe='') => {
            if(tipe == 'edit') {
                editModal.hide()
            }
        }

        const addSupplier = () => {
            let modal = $('#addModal'),
                kode = modal.find('.kode').val(),
                nama = modal.find('.nama').val(),
                telepon = modal.find('.telepon').val(),
                alamat = modal.find('.alamat').val()

            showLoadingScreen(true)

            $.ajax({
                type: 'POST',
                url: '/supplier',
                data: {
                    _token: '{{ csrf_token() }}',
                    kode: kode,
                    nama: nama,
                    telepon: telepon,
                    alamat: alamat
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

        const showSupplierDetail = (supplierId) => {
            let modal = $('#editModal')

            showLoadingScreen(true)

            $.ajax({
                type: 'GET',
                url: '/supplier/detail',
                data: {
                    supplier_id: supplierId
                },
                success: function(response) {
                    showLoadingScreen(false)

                    if(response.status == 'OK') {
                        modal.find('.supplier-id').val(response.supplier_detail.id)
                        modal.find('.kode').val(response.supplier_detail.kode)
                        modal.find('.nama').val(response.supplier_detail.nama)
                        modal.find('.telepon').val(response.supplier_detail.telepon)
                        modal.find('.alamat').val(response.supplier_detail.alamat)

                        editModal.show()
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

        const editSupplier = () => {
            let modal = $('#editModal'),
                supplier_id = modal.find('.supplier-id').val(),
                kode = modal.find('.kode').val(),
                nama = modal.find('.nama').val(),
                telepon = modal.find('.telepon').val(),
                alamat = modal.find('.alamat').val()

            showLoadingScreen(true)

            $.ajax({
                type: 'PUT',
                url: '/supplier',
                data: {
                    _token: '{{ csrf_token() }}',
                    supplier_id: supplier_id,
                    kode: kode,
                    nama: nama,
                    telepon: telepon,
                    alamat: alamat
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

        const deleteSupplier = (supplierId) => {
            if(confirm('Yakin Hapus Data Ini?')) {
                showLoadingScreen(true)
    
                $.ajax({
                    type: 'DELETE',
                    url: '/supplier',
                    data: {
                        _token: '{{ csrf_token() }}',
                        supplier_id: supplierId
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