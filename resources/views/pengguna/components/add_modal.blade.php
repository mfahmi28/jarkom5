<!-- ADD MODAL -->
<div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full modal">
    <div class="relative w-full max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    TAMBAH USER
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-6 space-y-6">
                <div class="mb-6">
                    <label class="text-sm font-semibold mb-3">Nama<span class="text-red-600">*</span></label>
                    <input type="text" class="nama w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan nama">
                </div>
                <div class="mb-6">
                    <label class="text-sm font-semibold mb-3">Username<span class="text-red-600">*</span></label>
                    <input type="text" class="username w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan username">
                </div>
                <div class="mb-6">
                    <label class="text-sm font-semibold mb-3">Email<span class="text-red-600">*</span></label>
                    <input type="email" class="email w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan email">
                </div>
                <div class="mb-6">
                    <label class="text-sm font-semibold mb-3">Password<span class="text-red-600">*</span></label>
                    <input type="password" class="password w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0" placeholder="Masukan password">
                </div>
                <div class="mb-6">
                    <label class="text-sm font-semibold mb-3">Role<span class="text-red-600">*</span></label>
                    <select class="role-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                        <option value="" selected disabled>-</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cabang-field hidden mb-6">
                    <label class="text-sm font-semibold mb-3">Cabang<span class="text-red-600">*</span></label>
                    <select class="cabang-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                        <option value="" selected disabled>-</option>
                        @foreach($cabangList as $cabang)
                        <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="supplier-field hidden mb-6">
                    <label class="text-sm font-semibold mb-3">Supplier<span class="text-red-600">*</span></label>
                    <select class="supplier-id w-full text-sm font-semibold p-3 bg-gray-50 rounded-lg border-0">
                        <option value="" selected disabled>-</option>
                        @foreach($supplierList as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center px-6 py-3 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <button data-modal-toggle="addModal" type="button" class="text-gray-500 bg-white hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 ml-auto">Tutup</button>
                <button type="button" class="text-white bg-primary hover:opacity-75 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="addUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>
