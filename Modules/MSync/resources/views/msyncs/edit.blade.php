@extends('layouts.app')

@section('title', 'Edit Data Sync')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h2>Edit Data Sync</h2>

            <form action="{{ route('msync.update', $msync->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                           value="{{ $msync->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim"
                           value="{{ $msync->nim }}" required>
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi"
                           value="{{ $msync->prodi }}" required>
                </div>

                <div class="mb-3">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <input type="text" class="form-control" id="fakultas" name="fakultas"
                           value="{{ $msync->fakultas }}" required>
                </div>

                <div class="mb-3">
                    <label for="universitas" class="form-label">Universitas</label>
                    <input type="text" class="form-control" id="universitas" name="universitas"
                           value="{{ $msync->universitas }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('msync.index') }}" class="btn btn-secondary">Batal</a>

            </form>

        </div>
    </div>
</div>
@endsection
