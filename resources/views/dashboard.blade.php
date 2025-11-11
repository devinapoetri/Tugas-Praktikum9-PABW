<x-app-layout>
    {{-- Header Dashboard --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        {{-- Pesan Sukses (Success Message) --}}
        @if (session('success'))
            <div class="mt-4 p-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- 1. Form Upload Berkas --}}
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-semibold mb-4">Upload Berkas</h3>
            
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="file" class="block font-medium text-sm text-gray-700">Pilih Berkas</label>
                    <input type="file" name="file" id="file" class="mt-2 border-gray-300 rounded-md shadow-sm w-full">
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Upload
                    </button>
                </div>
            </form>
        </div>

        {{-- 2. Daftar Berkas --}}
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-semibold mb-4">Daftar File</h3>
            
            <table class="min-w-full table-auto border-collapse border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama File</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Models\Upload::all() as $file)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $file->filename }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{-- Link Lihat Berkas --}}
                            <a href="{{ asset('storage/' . $file->filepath) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                            
                            {{-- Form Hapus Berkas (Hanya untuk Admin atau pemilik file) --}}
                            @if (auth()->user()->isAdmin() || $file->user_id == auth()->id())
                                <form action="{{ route('upload.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 italic">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 3. Daftar User (Hanya untuk Admin) --}}
        @if (auth()->user()->isAdmin())
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h3 class="text-lg font-semibold mb-4">Daftar User</h3>
                <table class="min-w-full table-auto border-collapse border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\User::all() as $user)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Hapus User
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-app-layout>