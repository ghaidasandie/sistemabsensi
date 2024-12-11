<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Siswa dengan QR Code</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .student-card {
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .student-card:hover {
            transform: translateY(-10px);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .qr-code {
            text-align: center;
            margin-top: 15px;
        }

        .qr-code svg {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Siswa</h1>

        <!-- Form Pencarian -->
        <div class="row mb-4">
            <div class="col-md-8 col-lg-6 mx-auto">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="Cari NISN atau Nama Siswa..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>

        <!-- Card Container -->
        <div class="card-container">
            @foreach ($siswas as $siswa)
                <div class="student-card">
                    <!-- Header -->
                    <div class="card-header">
                        {{ $siswa->nama }}
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                        <p><strong>Jenis Kelamin:</strong>
                            {{ $siswa->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</p>

                        <!-- QR Code -->
                        <div class="qr-code">
                            {!! QrCode::size(100)->generate($siswa->nisn) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
