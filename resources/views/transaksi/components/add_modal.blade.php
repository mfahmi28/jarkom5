<!-- ADD MODAL -->
<div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
    <div class="relative w-full max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    TAMBAH TRANSAKSI
                </h3>
                <button type="button" class="toggle-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal="addModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="create_form" class="modal-form">
                <div class="p-6 space-y-6">
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Order Number<span class="text-red-600">*</span></label>
                        <input id="create_order_code" type="text" name="order_code" class="kode w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan order number">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Supplier<span class="text-red-600">*</span></label>
                        {{-- <input type="hidden" name="create_supplier_id_old"> --}}
                        <select id="create_supplier_id" name="supplier_id" class="supplier_id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0 select2" placeholder="-">
                            <option value="" selected disabled>-</option>
                            @foreach($supplierList as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="text-sm font-semibold mb-3">Estimasi Tanggal Pengiriman<span class="text-red-600">*</span></label>
                        <input type="date" name="estimated_date" id="create_estimated_date" class="estimated_date w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan tanggal">
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Tujuan Cabang<span class="text-red-600">*</span></label>
                        <select id="create_cabang_id" name="cabang_id" class="cabang_id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                            <option value="" selected disabled>Pilih cabang tujuan</option>
                            @foreach($cabangList as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold mb-3">Keterangan<span class="text-red-600">*</span></label>
                        <textarea id="create_description" name="description" class="description w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <label class="text-sm font-semibold">Daftar Produk</label>
                    <input id="create_tax" type="hidden" value="{{App\Models\Transaksi::DEFAULT_TAX}}">
                    <hr class="mt-1 mb-4" style="">
                    <div  class="grid grid-cols-12 gap-x-4 items-end mb-6">
                        <div class="col-span-7">
                            <label class="text-sm font-semibold mb-3">Produk<span class="text-red-600">*</span></label>
                            <select id="create_produk_id" class="produk_id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" ></select>
                            {{-- <input id="create_produk_id" type="text" class="produk_id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Pilih produk"> --}}
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm font-semibold mb-3">Qty<span class="text-red-600">*</span></label>
                            <input id="create_qty" type="number" class="qty w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="0">
                        </div>
                        <div class="col-span-2">
                            <button type="button" id="create_produk_add" class="bg-green-500 w-full py-1.5 rounded-lg text-2xl text-white cursor-pointer">+</button>
                        </div>
                    </div>

                    <div id="create_product_list">
                    </div>

                    <div class="bg-purple-100 border border-secondary p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Total Harga Produk</label>
                            <div id="create_calc_products" class="text-sm font-semibold">&nbsp;</div>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Pajak</label>
                            <div id="create_calc_tax" class="text-sm font-semibold">&nbsp;</div>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Sub Total</label>
                            <div id="create_calc_subtotal" class="text-sm font-semibold">&nbsp;</div>
                        </div>
                        <hr class="my-4 border-secondary">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold">Total</label>
                            <div id="create_calc_total" class="text-sm font-semibold">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                <button type="button" onclick="addTransaksi()" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
            </div>
        </div>
    </div>
</div>
