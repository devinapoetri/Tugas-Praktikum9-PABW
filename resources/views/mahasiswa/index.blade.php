@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Data Mahasiswa</h1>

    <button class="btn btn-primary mb-3" id="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Data
    </button>

    <table class="table table-bordered" id="tabel-mahasiswa">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-mahasiswa" tabindex="-1" aria-labelledby="modalMahasiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMahasiswaLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-mahasiswa">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text" class="form-control" id="nim" required>
                    </div>
                    <div class="mb-3">
                        <label>Prodi</label>
                        <input type="text" class="form-control" id="prodi" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // === LOAD DATA ===
    function loadData() {
        $.get('/mahasiswa/data', function(response) {
            let rows = '';
            response.data.forEach((item, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.nim}</td>
                        <td>${item.prodi}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit text-white" data-id="${item.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus" data-id="${item.id}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#tabel-mahasiswa tbody').html(rows);
        });
    }

    loadData();

    // === TOMBOL TAMBAH ===
    $('#btn-tambah').click(function() {
        $('#modalMahasiswaLabel').text('Tambah Mahasiswa');
        $('#form-mahasiswa')[0].reset();
        $('#id').val('');
        $('#modal-mahasiswa').modal('show');
    });

    // === SIMPAN DATA ===
    $('#form-mahasiswa').submit(function(e) {
        e.preventDefault();
        const id = $('#id').val();
        const url = id ? '/mahasiswa/update/' + id : '/mahasiswa/store';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                nama: $('#nama').val(),
                nim: $('#nim').val(),
                prodi: $('#prodi').val(),
            },
            success: function() {
                $('#modal-mahasiswa').modal('hide');
                loadData();
            },
            error: function(xhr) {
                alert('Gagal menyimpan data: ' + xhr.responseText);
            }
        });
    });

        // === EDIT DATA ===
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $.get('/mahasiswa/edit/' + id, function(data) {
                $('#modalMahasiswaLabel').text('Edit');
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#nim').val(data.nim);
                $('#prodi').val(data.prodi);
                $('#modal-mahasiswa').modal('show');
            });
        });

        // === HAPUS DATA ===
        $(document).on('click', '.btn-hapus', function()  {
            if (confirm('Yakin ingin menghapus data ini?')) {
                const id = $(this).data('id');
                $('#modalMahasiswaLabel').text('Hapus');
                $.ajax({
                    url: '/mahasiswa/delete/' + id,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() {
                        loadData();
                    },
                    error: function() {
                        alert('Gagal menghapus data.');
                    }
                });
            }
        });
    });
    </script>
@endpush
