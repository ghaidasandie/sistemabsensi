<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

        /* Style untuk tabel */
        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            font-size: 1rem;
        }

        .table td {
            font-size: 0.9rem;
        }

        .table .action-btns i {
            font-size: 1.2rem;
            cursor: pointer;
            margin-right: 10px;
        }

        .table .action-btns i:hover {
            color: #007bff;
        }

        .bg-light {
            background-color: #f0f0f0 !important;
            color: #6c757d;
        }

        input[readonly],
        select[disabled] {
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu">
            <h3 class="text-center">Menu</h3>
            <a href="/dashboard">Dashboard</a>
            <a href="/admin">Data Siswa</a>
            <a href="/absensi" class="active">Data Absensi</a>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <div class="container mt-3">
            <h1 class="text-center mb-4">Daftar Absensi</h1>

            <!-- Button Tambah Data Absensi -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahAbsensiModal">+ Tambah Data Absensi</button>

            <!-- Tabel Absensi -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>Status</th>
                            <th>Koordinat</th>
                            <th>Tanggal Ditambahkan</th>
                            <th>Tanggal Diubah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensis as $absensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absensi->nisn }}</td>
                                <td>{{ $absensi->status }}</td>
                                <td>{{ $absensi->koordinat }}</td>
                                <td>{{ $absensi->created_at->format('d M Y') }}</td>
                                <td>{{ $absensi->updated_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editAbsensiModal{{ $absensi->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- Previous Button -->
                        <li class="page-item {{ $absensis->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $absensis->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Pagination Numbers -->
                        @for ($i = 1; $i <= $absensis->lastPage(); $i++)
                            <li class="page-item {{ $i == $absensis->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $absensis->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Button -->
                        <li class="page-item {{ $absensis->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $absensis->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <!-- Modal Tambah Data Absensi -->
    <div class="modal fade" id="tambahAbsensiModal" tabindex="-1" aria-labelledby="tambahAbsensiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahAbsensiModalLabel">Tambah Data Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <select class="form-select" id="nisn" name="nisn" required
                                onchange="updateKoordinat()">
                                <option value="" disabled selected>Pilih NISN</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->nisn }}" data-koordinat="{{ $siswa->koordinat }}">
                                        {{ $siswa->nisn }} - {{ $siswa->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="i">Izin</option>
                                <option value="s">Sakit</option>
                                <option value="h">Alfa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="koordinat" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="koordinat" name="koordinat" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Absensi -->
    @foreach ($absensis as $absensi)
        <div class="modal fade" id="editAbsensiModal{{ $absensi->id }}" tabindex="-1"
            aria-labelledby="editAbsensiModalLabel{{ $absensi->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Form untuk mengupdate absensi -->
                    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAbsensiModalLabel{{ $absensi->id }}">Edit Data Absensi
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control bg-light" value="{{ $absensi->nisn }}"
                                    readonly>
                            </div>

                            <!-- Status (editable) -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="i" {{ $absensi->status == 'i' ? 'selected' : '' }}>Izin
                                    </option>
                                    <option value="s" {{ $absensi->status == 's' ? 'selected' : '' }}>Sakit
                                    </option>
                                    <option value="a" {{ $absensi->status == 'a' ? 'selected' : '' }}>Alfa
                                    </option>
                                </select>
                            </div>

                            <!-- Koordinat (readonly) -->
                            <div class="mb-3">
                                <label for="koordinat" class="form-label">Koordinat</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $absensi->koordinat }}" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk mengupdate koordinat saat memilih NISN -->
    <script>
        function updateKoordinat() {
            var nisnSelect = document.getElementById('nisn');
            var selectedOption = nisnSelect.options[nisnSelect.selectedIndex];
            var koordinat = selectedOption.getAttribute('data-koordinat');
            document.getElementById('koordinat').value = koordinat;
        }
    </script>

</body>

</html>
