<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <h1 class="text-center mb-4">Laporan Absensi</h1>
    <p>Periode: {{ \Carbon\Carbon::parse($dateStart)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($dateEnd)->format('d M Y') }}</p>

    <!-- Tabel Absensi -->
    <table>
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
</body>
</html>
