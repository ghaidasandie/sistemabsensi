<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
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
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: block;
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

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
            gap: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        /* Custom Colors for Ranking */
        .bg-rank-1 {
            background-color: #28a745;
        }

        .bg-rank-2 {
            background-color: #007bff;
        }

        .bg-rank-3 {
            background-color: #ffc107;
        }

        .bg-rank-other {
            background-color: #f8f9fa;
        }

        .bg-rank-bottom-1 {
            background-color: #dc3545;
        }

        .bg-rank-bottom-2 {
            background-color: #c82333;
        }

        .bg-rank-bottom-3 {
            background-color: #bd2130;
        }

        .bg-rank-bottom-other {
            background-color: #f8d7da;
        }

        .section-separator {
            margin-top: 40px;
            border-top: 3px solid #ddd;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Menu</h3>
        <div class="menu">
            <a href="/dashboard" class="active">Dashboard</a>
            <a href="/admin">Data Siswa</a>
            <a href="/absensi">Data Absensi</a>
            <a href="/status">Status</a>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="text-center mb-4">Ranking Siswa Berdasarkan Absensi</h1>
        <div class="section-separator"></div>

        <!-- Card Ranking Terbaik -->
        <h3 class="mb-4 text-success">5 Ranking Terbaik</h3>
        <div class="card-container">
            @foreach ($topRanking->unique('nisn') as $index => $siswa)
                <div class="card
                    {{ $index == 0 ? 'bg-rank-1' : ($index == 1 ? 'bg-rank-2' : ($index == 2 ? 'bg-rank-3' : 'bg-rank-other')) }}">
                    <div class="card-body">
                        <h5 class="card-title">Ranking {{ $index + 1 }}</h5>
                        <h6 class="card-subtitle mb-2">{{ $siswa->nama }}</h6>
                        <p class="card-text"><strong>Total Poin:</strong> {{ $siswa->total_points }} Poin</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section-separator"></div>

        <!-- Card Ranking Terburuk -->
        <h3 class="mb-4 text-danger">5 Ranking Terburuk</h3>
        <div class="card-container">
            @foreach ($bottomRanking->unique('nisn') as $index => $siswa)
                <div class="card
                    {{ $index == 0 ? 'bg-rank-bottom-1' : ($index == 1 ? 'bg-rank-bottom-2' : ($index == 2 ? 'bg-rank-bottom-3' : 'bg-rank-bottom-other')) }}">
                    <div class="card-body">
                        <h5 class="card-title">Ranking {{ $index + 1 }}</h5>
                        <h6 class="card-subtitle mb-2">{{ $siswa->nama }}</h6>
                        <p class="card-text"><strong>Total Poin:</strong> {{ $siswa->total_points }} Poin</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
