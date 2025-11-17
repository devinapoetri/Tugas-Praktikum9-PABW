@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Pendaftaran</h3>
                </div>

                <div class="card-body">

                    <!-- Button Tambah -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#pendaftaranModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="pendaftaran-table">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Asal Sekolah</th>
                                    <th>Prodi Tujuan</th>
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
<div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-labelledby="pendaftaranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="pendaftaranModalLabel">Form Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="pendaftaranForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="invalid-feedback" id="nama-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required>
                        <div class="invalid-feedback" id="asal_sekolah-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="prodi_tujuan" class="form-label">Prodi Tujuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prodi_tujuan" name="prodi_tujuan" required>
                        <div class="invalid-feedback" id="prodi_tujuan-error"></div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                <button type="button" class="btn btn-primary" id="saveBtn">
                    <span class="submit-text">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .invalid-feedback {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {

    // CSRF Token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Load Data
    loadData();

    function loadData() {
        $.ajax({
            url: "{{ route('pendaftaran.data') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let html = '';
                let no = 1;

                if (data.length > 0) {
                    data.forEach(item => {
                        html += `
                            <tr>
                                <td>${no++}</td>
                                <td>${item.nama}</td>
                                <td>${item.asal_sekolah}</td>
                                <td>${item.prodi_tujuan}</td>
                                <td class="text-center">
                                    <button data-id="${item.id}" class="edit btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button data-id="${item.id}" class="delete btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>`;
                }

                $('#pendaftaran-table tbody').html(html);
            },
            error: function(xhr) {
                alert('Gagal memuat data.');
            }
        });
    }

    const pendaftaranModal = new bootstrap.Modal('#pendaftaranModal');

    // Reset modal saat ditutup
    $('#pendaftaranModal').on('hidden.bs.modal', function () {
        $('#pendaftaranForm').trigger("reset");
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');
        $('#id').val('');
    });

    // Simpan Data
    $('#saveBtn').click(function(e) {
        e.preventDefault();

        const btn = $(this);
        btn.prop('disabled', true);
        btn.find('.submit-text').text('Menyimpan...');
        btn.find('.spinner-border').removeClass('d-none');

        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('pendaftaran.store') }}",
            type: "POST",
            data: $('#pendaftaranForm').serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    bootstrap.Modal.getInstance(document.getElementById('pendaftaranModal')).hide();
                    loadData();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid');
                        $(`#${key}-error`).text(value[0]);
                    });
                } else {
                    alert('Terjadi kesalahan.');
                }
            },
            complete: function() {
                btn.prop('disabled', false);
                btn.find('.submit-text').text('Simpan');
                btn.find('.spinner-border').addClass('d-none');
            }
        });
    });

    // Edit
    $(document).on('click', '.edit', function() {
        const id = $(this).data('id');

        $.get("{{ route('pendaftaran.index') }}/" + id + "/edit", function(data) {
            $('#pendaftaranModalLabel').text("Edit Pendaftaran");

            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#asal_sekolah').val(data.asal_sekolah);
            $('#prodi_tujuan').val(data.prodi_tujuan);

            pendaftaranModal.show();
        });
    });

    // Hapus
    $(document).on('click', '.delete', function() {
        const id = $(this).data('id');

        if (confirm("Yakin ingin menghapus?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('pendaftaran.index') }}/" + id,
                success: function(res) {
                    if (res.success) loadData();
                }
            });
        }
    });

});
</script>
@endpush
