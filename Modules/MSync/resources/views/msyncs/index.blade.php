@extends('layouts.app')
@section('title', 'Daftar Data Sync')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar Data Sync</h2>
                <a href="{{ route('msync.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Fakultas</th>
                        <th>Universitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($msyncs as $msync)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $msync->nama }}</td>
                        <td>{{ $msync->nim }}</td>
                        <td>{{ $msync->prodi }}</td>
                        <td>{{ $msync->fakultas }}</td>
                        <td>{{ $msync->universitas }}</td>

                        <td>
                            <a href="{{ route('msync.show', $msync->id) }}" class="btn btn-info btn-sm">Lihat</a>

                            <a href="{{ route('msync.edit', $msync->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('msync.destroy', $msync->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

            {{ $msyncs->links() }}

        </div>
    </div>
</div>
@endsection
