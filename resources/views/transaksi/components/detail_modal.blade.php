<!-- DETAIL MODAL -->
<div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
    <div class="relative w-full max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    DETAIL TRANSAKSI
                </h3>
                <button type="button" class="toggle-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal="detailModal">
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
                        <label id="detail_order_code" class="text-sm font-semibold">ORD-0001</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Tipe</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_tipe" class="text-sm font-semibold">ORD-0001</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Supplier</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_supplier" class="text-sm font-semibold">PT. Indofood Makmur</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Est. Tanggal Pengiriman</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_estimated_date" class="text-sm font-semibold">31 Nov 2022</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Tujuan Cabang</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_supplier" class="text-sm font-semibold">Bandung</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Keterangan</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_description" class="text-sm font-semibold">keterangan order ini adalah untuk pemasaran</label>
                    </div>
                    <div class="col-span-5">
                        <label class="text-sm font-bold">Status</label>
                    </div>
                    <div class="col-span-7">
                        <label id="detail_status_name" class="text-sm font-semibold">Pending</label>
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
                                    <th class="py-4 px-6 w-28 retur-field">Qty Retur</th>
                                </tr>
                            </thead>
                            <tbody id="detail_list_produks">
                                {{-- listProdukTemplate --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-purple-100 border border-secondary p-4 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Total Harga Produk</label>
                            <div id="detail_total_produk" class="text-sm font-semibold"></div>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Pajak</label>
                            <div id="detail_tax" class="text-sm font-semibold">Rp</div>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold">Sub Total</label>
                            <div id="detail_sub_total" class="text-sm font-semibold">Rp</div>
                        </div>
                        <hr class="my-4 border-secondary">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold">Total</label>
                            <div id="detail_total" class="text-sm font-semibold">Rp</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="detail_apply" class="flex items-center justify-end px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <!-- <button data-modal="detailModal" type="button" class="toggle-modal text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button> -->
                @role("md")
                <button type="button" data-action="reject" class="btn-approve text-white w-28 bg-red-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reject</button>
                <button type="button" data-action="approve" class="btn-approve text-white w-28 bg-green-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approve</button>
                @endrole
                @role("supplier")
                <button type="button" data-action="ship" class="btn-ship text-white w-28 bg-green-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Shipping</button>
                @endrole
                @role("admin-cabang")
                <button type="button" data-action="recieve" class="btn-receive text-white w-28 bg-green-500 hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Receive</button>
                @endrole
            </div>
        </div>
    </div>
</div>