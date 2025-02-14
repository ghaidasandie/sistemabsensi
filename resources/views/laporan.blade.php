<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling untuk sidebar dan tabel */
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

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
            padding: 12px 15px;
        }

        .table th {
            font-size: 1rem;
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }

        .table td {
            font-size: 0.9rem;
            background-color: #f8f9fa;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk pagination */
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
            border-color: #dee2e6;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="menu">
            <h3 class="text-center">Menu</h3>
            <a href="/dashboard">Dashboard</a>
            <a href="/siswa">Data Siswa</a>
            <a href="/absensi">Data Absensi</a>
            <a href="/status">Status</a>
            <a href="/laporan" class="active">Laporan</a>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="content">
        <div class="container mt-3">
            <h1 class="text-center mb-4">Laporan Absensi</h1>

            <!-- Form untuk memilih rentang tanggal -->
            <div class="d-flex justify-content-between mb-3">
                <form action="/laporan" method="GET" class="d-flex gap-2">
                    <div>
                        <input type="date" name="date_start" class="form-control"
                            value="{{ request()->get('date_start', now()->startOfMonth()->toDateString()) }}">
                    </div>
                    <div>
                        <input type="date" name="date_end" class="form-control"
                            value="{{ request()->get('date_end', now()->toDateString()) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </form>
                <form action="{{ route('laporan.export') }}" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="date_start"
                        value="{{ request()->get('date_start', now()->startOfMonth()->toDateString()) }}">
                    <input type="hidden" name="date_end"
                        value="{{ request()->get('date_end', now()->toDateString()) }}">
                    <button type="submit" class="btn btn-success">Download PDF</button>
                </form>
            </div>

            <p>Periode: {{ \Carbon\Carbon::parse($dateStart)->format('d M Y') }} sampai
                {{ \Carbon\Carbon::parse($dateEnd)->format('d M Y') }}</p>

            <!-- Tabel Absensi -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Koordinat</th>
                            <th>Tanggal Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensis as $absensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absensi->nisn }}</td>
                                <td>{{ $absensi->siswa->nama }}</td>
                                <td>{{ $absensi->status }}</td>
                                <td>{{ $absensi->koordinat }}</td>
                                <td>{{ $absensi->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Tombol Previous -->
                        @if ($absensis->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $absensis->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        <!-- Nomor Halaman -->
                        @php
                            $totalPages = $absensis->lastPage();
                            $currentPage = $absensis->currentPage();
                        @endphp

                        @if ($totalPages <= 5)
                            <!-- Jika total halaman <= 5, tampilkan semua halaman -->
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $absensis->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                        @else
                            <!-- Tampilkan Halaman Pertama -->
                            <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                                <a class="page-link" href="{{ $absensis->url(1) }}">1</a>
                            </li>

                            <!-- Tambahkan ... jika halaman saat ini lebih dari 3 -->
                            @if ($currentPage > 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Tampilkan 2 halaman sebelum & sesudah halaman aktif -->
                            @for ($page = max(2, $currentPage - 1); $page <= min($totalPages - 1, $currentPage + 1); $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $absensis->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Tambahkan ... jika halaman aktif kurang dari total - 2 -->
                            @if ($currentPage < $totalPages - 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Tampilkan Halaman Terakhir -->
                            <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                                <a class="page-link" href="{{ $absensis->url($totalPages) }}">{{ $totalPages }}</a>
                            </li>
                        @endif

                        <!-- Tombol Next -->
                        @if ($absensis->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $absensis->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>


</body>

</html>
