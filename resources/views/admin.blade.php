<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 15px;
        }

        .menu {
            flex-grow: 1;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar a.active {
            background-color: #007bff;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: center;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Modal Responsive */
        .modal-dialog {
            max-width: 800px;
            /* Atur lebar maksimal modal */
        }

        .modal-content {
            border-radius: 10px;
        }

        /* Peningkatan Tombol pada Tabel */
        .btn-sm {
            font-size: 14px;
            padding: 5px 10px;
        }

        /* Logout Button Styles */
        .logout-btn {
            width: 100%;
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            border-radius: 5px !important;
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid #dee2e6;
            color: #007bff;
            min-width: 38px;
            text-align: center;
        }

        .page-link:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu">
            <h3 class="text-center text-white">Menu</h3>
            <a href="/dashboard">Dashboard</a>
            <a href="/siswa" class="active">Data Siswa</a>
            <a href="/absensi">Data Absensi</a>
            <a href="/status">Status</a>
            <a href="/laporan">Laporan</a>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container mt-3">
            <h1 class="text-center mb-4">Daftar Siswa</h1>
            <div class="d-flex justify-content-between mb-3">
                <!-- Tombol Tambah Data Siswa -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">+ Tambah Data
                    Siswa</button>

                <form action="{{ route('siswa.search') }}" method="GET" class="d-flex w-50">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari berdasarkan nama atau NISN" value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-primary ms-2">Cari</button>
                </form>
            </div>


            <!-- Success Notification using SweetAlert -->
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                </script>
            @endif

            <!-- Error Notification -->
            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ session('error') }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                </script>
            @endif
            <!-- Table of Students -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td>{{ ($siswas->currentPage() - 1) * $siswas->perPage() + $loop->iteration }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->tanggal_lahir }}</td>
                                <td>{{ $siswa->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $siswa->alamat }}</td>
                                <td>{{ $siswa->koordinat }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editSiswaModal{{ $siswa->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal Edit Siswa -->
            @foreach ($siswas as $siswa)
                <div class="modal fade" id="editSiswaModal{{ $siswa->id }}" tabindex="-1"
                    aria-labelledby="editSiswaModalLabel{{ $siswa->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSiswaModalLabel{{ $siswa->id }}">Edit Data Siswa
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form Fields for Editing Student Data -->
                                    <div class="mb-3">
                                        <label for="nisn" class="form-label">NISN</label>
                                        <input type="number" class="form-control @error('nisn') is-invalid @enderror"
                                            id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                                            required>
                                        @error('nisn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $siswa->nama) }}"
                                            required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin" required>
                                            <option value="l"
                                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'l' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="p"
                                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'p' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="koordinat" class="form-label">Koordinat</label>
                                        <input type="text"
                                            class="form-control @error('koordinat') is-invalid @enderror"
                                            id="koordinat" name="koordinat"
                                            value="{{ old('koordinat', $siswa->koordinat) }}" required>
                                        @error('koordinat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($siswas->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswas->previousPageUrl() }}"
                                    aria-label="Previous">Previous</a>
                            </li>
                        @endif

                        <!-- Page Number Links -->
                        @php
                            $totalPages = $siswas->lastPage();
                            $currentPage = $siswas->currentPage();
                        @endphp

                        @if ($totalPages <= 5)
                            <!-- Jika total halaman <= 5, tampilkan semua halaman -->
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $siswas->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                        @else
                            <!-- Tampilkan Halaman Pertama -->
                            <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                                <a class="page-link" href="{{ $siswas->url(1) }}">1</a>
                            </li>

                            <!-- Tambahkan ... jika halaman saat ini lebih dari 3 -->
                            @if ($currentPage > 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Tampilkan 2 halaman sebelum & sesudah halaman aktif -->
                            @for ($page = max(2, $currentPage - 1); $page <= min($totalPages - 1, $currentPage + 1); $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $siswas->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Tambahkan ... jika halaman aktif kurang dari total - 2 -->
                            @if ($currentPage < $totalPages - 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Tampilkan Halaman Terakhir -->
                            <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                                <a class="page-link" href="{{ $siswas->url($totalPages) }}">{{ $totalPages }}</a>
                            </li>
                        @endif

                        <!-- Next Page Link -->
                        @if ($siswas->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswas->nextPageUrl() }}" aria-label="Next">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>



            <!-- Add Data Modal -->
            <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('siswa.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Fields for Student Data -->
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">NISN</label>
                                    <input type="number" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahhir">Tanggal lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required>
                                        <option value="l" {{ old('jenis_kelamin') == 'l' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="p" {{ old('jenis_kelamin') == 'p' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="koordinat" class="form-label">Koordinat</label>
                                    <input type="text"
                                        class="form-control @error('koordinat') is-invalid @enderror" id="koordinat"
                                        name="koordinat" value="{{ old('koordinat') }}" required>
                                    @error('koordinat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
</body>

</html>
