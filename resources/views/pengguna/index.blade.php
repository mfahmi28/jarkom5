@extends('layouts.page')

@section('content')
    <div class="flex item-center justify-between mb-8">
        <div class="flex cursor-pointer">
            <a href="/beranda" class="flex items-center">
                <i class="mdi mdi-arrow-left text-4xl mr-3"></i>
                <span class="font-semibold text-2xl">User</span>
            </a>
        </div>
        <div class="flex items-center cursor-pointer">
            <i class="mdi mdi-plus text-lg mr-2"></i>
            <span class="text-lg font-semibold" data-modal-toggle="addModal">Tambah User</span>
        </div>
    </div>
    <div class="rounded-xl overflow-x-auto shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-secondary text-white">
                <tr>
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Role</th>
                    <th class="py-4 px-6 text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($users))
                    @foreach($users as $idx => $user)
                    <tr class="{{ $idx%2 ? 'bg-purple-100' : 'bg-white' }}">
                        <td class="py-4 px-6">{{ $user->name }}</td>
                        <td class="py-4 px-6">{{ $user->role->name }}</td>
                        <td class="py-4 px-6 text-center">
                            <i class="mdi mdi-pencil text-lg cursor-pointer hover:opacity-75 text-yellow-300 mr-5" onclick="showPenggunaDetail('{{ $user->id }}')"></i>
                            <i class="mdi mdi-delete text-lg cursor-pointer hover:opacity-75 text-red-600" onclick="deleteUser('{{ $user->id }}')"></i>
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
        {{ $users->links('pagination::tailwind') }}
    </div>

    @include('pengguna.components.add_modal')
    @include('pengguna.components.detail_modal')

@endsection

@section('javascript')
    <script>
        let editModal = new Modal(document.getElementById('editModal'), {})

        const closeModal = (tipe='') => {
            if(tipe == 'edit') {
                editModal.hide()
            }
        }

        const addUser = () => {
            let modal = $('#addModal'),
                name = modal.find('.nama').val(),
                username = modal.find('.username').val(),
                email = modal.find('.email').val(),
                password = modal.find('.password').val(),
                role_id = modal.find('.role-id').val();

            showLoadingScreen(true)

            $.ajax({
                type: 'POST',
                url: '/pengguna',
                data: {
                    _token: '{{ csrf_token() }}',
                    name,
                    username,
                    email,
                    password,
                    role_id
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

        const showPenggunaDetail = (penggunaId) => {
            let modal = $('#editModal')

            showLoadingScreen(true)

            $.ajax({
                type: 'GET',
                url: '/pengguna/detail',
                data: {
                    pengguna_id: penggunaId
                },
                success: function(response) {
                    showLoadingScreen(false)

                    if(response.status == 'OK') {
                        modal.find('.pengguna-id').val(response.user_detail.id)
                        modal.find('.nama').val(response.user_detail.name)
                        modal.find('.username').val(response.user_detail.username)
                        modal.find('.email').val(response.user_detail.email)
                        modal.find('.password').val("")
                        modal.find('.role-id').val(response.user_detail.role_id)

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

        const editUser = () => {
            let modal = $('#editModal'),
                penggunaId = modal.find('.pengguna-id').val(),
                name = modal.find('.nama').val(),
                username = modal.find('.username').val(),
                email = modal.find('.email').val(),
                password = modal.find('.password').val(),
                role_id = modal.find('.role-id').val();


            showLoadingScreen(true)

            $.ajax({
                type: 'PUT',
                url: '/pengguna',
                data: {
                    _token: '{{ csrf_token() }}',
                    pengguna_id: penggunaId,
                    name,
                    username,
                    email,
                    password,
                    role_id
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

        const deleteUser = (penggunaId) => {
            if(confirm('Yakin Hapus Data Ini?')) {
                showLoadingScreen(true)

                $.ajax({
                    type: 'DELETE',
                    url: '/pengguna',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pengguna_id: penggunaId
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
