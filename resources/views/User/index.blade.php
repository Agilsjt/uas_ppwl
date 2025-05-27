@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 rounded-4 shadow-lg" style="background-color: rgba(255, 255, 255, 0.1);">
        <div class="card-body text-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Daftar User</h2>
                <a href="{{ route('user.create') }}" class="btn btn-success px-4 fw-semibold rounded-pill shadow-sm">
                    + Tambah User
                </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('user.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-white bg-opacity-75 text-dark border-0" placeholder="Cari user..." value="{{ request('search') }}">
                    <button class="btn btn-outline-light fw-semibold" type="submit">Cari</button>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive rounded-4 overflow-hidden">
                <table class="table table-hover text-white align-middle text-center m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="table-row-hover">
                                <td>{{ $user->id }}</td>
                                <td class="text-start">{{ $user->name }}</td>
                                <td class="text-start">{{ $user->email }}</td>
                                <td>
                                    {{-- Jika role relasi many-to-many --}}
                                    @if($user->roles->isNotEmpty())
                                        <span class="badge bg-light text-dark fw-normal">{{ $user->roles->pluck('name')->join(', ') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-info btn-sm me-1">Detail</a>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada data user yang ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .table-row-hover:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ccc;
    }
</style>
