@extends('layouts.app')

@section('title', 'Detail Data Sync')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h2>Detail Data Sync</h2>

            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">{{ $msync->nama }}</h5>

                    <p class="card-text"><strong>NIM:</strong> {{ $msync->nim }}</p>
                    <p class="card-text"><strong>Prodi:</strong> {{ $msync->prodi }}</p>
                    <p class="card-text"><strong>Fakultas:</strong> {{ $msync->fakultas }}</p>
                    <p class="card-text"><strong>Universitas:</strong> {{ $msync->universitas }}</p>

                    <a href="{{ route('msync.edit', $msync->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('msync.destroy', $msync->id) }}"
                          method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                            Hapus
                        </button>
                    </form>

                    <a href="{{ route('msync.index') }}" class="btn btn-secondary">Kembali</a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
