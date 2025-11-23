@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Data Mahasiswa</h3>
                </div>

                <div class="card-body">

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#mahasiswaModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="mahasiswa-table">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th>Universitas</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data via AJAX -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mahasiswaModal" tabindex="-1" aria-labelledby="mahasiswaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="mahasiswaModalLabel">Form Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="mahasiswaForm">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="invalid-feedback" id="nama-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                        <div class="invalid-feedback" id="nim-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prodi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prodi" name="prodi" required>
                        <div class="invalid-feedback" id="prodi-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" required>
                        <div class="invalid-feedback" id="fakultas-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Universitas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="universitas" name="universitas" required>
                        <div class="invalid-feedback" id="universitas-error"></div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveBtn">
                    <span class="submit-text">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadData();

    function loadData() {
        $.ajax({
            url: "{{ route('mahasiswa.data') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let html = "";
                let no = 1;

                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${no++}</td>
                            <td>${item.nama}</td>
                            <td>${item.nim}</td>
                            <td>${item.prodi}</td>
                            <td>${item.fakultas}</td>
                            <td>${item.universitas}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm edit" data-id="${item.id}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete" data-id="${item.id}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>`;
                });

                $('#mahasiswa-table tbody').html(html);
            }
        });
    }

    // Simpan
    $('#saveBtn').click(function() {
        $.ajax({
            url: "{{ route('mahasiswa.store') }}",
            type: "POST",
            data: $('#mahasiswaForm').serialize(),
            dataType: "json",

            success: function(response) {
                $('#mahasiswaModal').modal('hide');
                $('#mahasiswaForm')[0].reset();
                loadData();
            },

            error: function(xhr) {
                $('.invalid-feedback').text("");
                $('.form-control').removeClass('is-invalid');

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '-error').text(value[0]);
                    });
                }
            }
        });
    });

    // Edit
    $(document).on('click', '.edit', function() {
        let id = $(this).data('id');

        $.get("{{ route('mahasiswa.index') }}/" + id + "/edit", function(data) {
            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#nim').val(data.nim);
            $('#prodi').val(data.prodi);
            $('#fakultas').val(data.fakultas);
            $('#universitas').val(data.universitas);

            $('#mahasiswaModalLabel').text("Edit Mahasiswa");
            $('#mahasiswaModal').modal('show');
        });
    });

    // Hapus
    $(document).on('click', '.delete', function() {
        let id = $(this).data('id');

        if (confirm("Yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "{{ route('mahasiswa.index') }}/" + id,
                type: "DELETE",
                success: function() {
                    loadData();
                }
            });
        }
    });

});
</script>
@endpush
