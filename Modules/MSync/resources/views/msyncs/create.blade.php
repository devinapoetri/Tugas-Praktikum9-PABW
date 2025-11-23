@extends('layouts.app')

@section('title', 'Tambah Data Sync')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h2>Tambah Data Sync</h2>

            <form action="{{ route('msync.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" required>
                </div>

                <div class="mb-3">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <input type="text" class="form-control" id="fakultas" name="fakultas" required>
                </div>

                <div class="mb-3">
                    <label for="universitas" class="form-label">Universitas</label>
                    <input type="text" class="form-control" id="universitas" name="universitas" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('msync.index') }}" class="btn btn-secondary">Batal</a>
            </form>

        </div>
    </div>
</div>
@endsection
