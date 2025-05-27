@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 rounded-4 shadow-lg" style="background-color: rgba(255, 255, 255, 0.1);">
        <div class="card-body text-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Daftar Pegawai</h2>
                <a href="{{ route('employee.create') }}" class="btn btn-success px-4 fw-semibold rounded-pill shadow-sm">
                    + Tambah Pegawai
                </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('employee.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-white bg-opacity-75 text-dark border-0" placeholder="Cari Pegawai..." value="{{ request('search') }}">
                    <button class="btn btn-outline-light fw-semibold" type="submit">Cari</button>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive rounded-4 overflow-hidden">
                <table class="table table-hover text-white align-middle text-center m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Foto Pegawai</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Hp</th>
                            <th>Alamat</th>
                            <th>Jabatan</th>
                            <th>Skills</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="table-row-hover">
                                <td>
                                    @if ($employee->profile_picture)
                                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture"
                                            class="rounded-circle border border-white shadow-sm" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td class="text-start">{{ $employee->name }}</td>
                                <td class="text-start">{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td class="text-start">{{ $employee->address }}</td>
                                <td>{{ $employee->position }}</td>
                                <td class="text-start">
                                    @forelse ($employee->skills as $skill)
                                        <span class="badge bg-light text-dark fw-normal">{{ $skill->name }}</span>
                                    @empty
                                        <span class="text-muted">Masih tidak ada skill yang dimasukkan</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-info btn-sm me-1">Detail</a>
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                    <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Tidak ada data pegawai yang ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $employees->withQueryString()->links('pagination::bootstrap-5') }}
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
