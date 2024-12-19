<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absebsi</title>
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
        .table td, .table th {
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

            <!-- Tabel -->
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
                                <div class="d-flex justify-content-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/siswa" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="number" class="form-control" id="nisn" name="nisn" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="koordinat" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="koordinat" name="koordinat" required>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
