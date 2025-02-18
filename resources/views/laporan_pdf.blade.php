<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .date-range {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
            color: #555;
        }

        /* Pie Chart styling */
        .pie-chart-container {
            text-align: center;
            margin: 20px 0;
        }

        .pie-chart-container img {
            width: 50%;
            height: auto;
        }

        /* Best Student section */
        .best-student-info {
            background-color: #eaf1e6;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .best-student-info h3 {
            color: #28a745;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .best-student-info p {
            font-size: 18px;
            color: #333;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #343a40;
            color: white;
            font-size: 16px;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        /* Footer section */
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #aaa;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Absensi</h1>
        <p class="date-range">Periode: {{ \Carbon\Carbon::parse($dateStart)->format('d M Y') }} sampai
            {{ \Carbon\Carbon::parse($dateEnd)->format('d M Y') }}</p>

        <!-- Pie Chart -->
        <div class="pie-chart-container">
            <h3>Distribusi Absensi</h3>
            <img src="data:image/png;base64,{{ $chartImage }}" alt="Pie Chart Absensi" />
        </div>

        <!-- Siswa yang Paling Sering Hadir -->
        <div class="best-student-info">
            <h3>Siswa yang Paling Sering Hadir</h3>
            <p><strong>{{ $siswaHadirTerbanyak['nama'] }}</strong> dengan <strong>{{ $siswaHadirTerbanyak['hadir'] }}
                    Kehadiran</strong></p>
        </div>

        <!-- Table Absensi -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($siswaAbsensi as $absensi)
                    <tr>
                        <!-- Menampilkan nomor urut otomatis menggunakan $loop->iteration -->
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $absensi['nisn'] }}</td>
                        <td>{{ $absensi['nama'] }}</td>
                        <td>{{ $absensi['hadir'] }}</td>
                        <td>{{ $absensi['izin'] }}</td>
                        <td>{{ $absensi['sakit'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Buatan Kelompok-1 - {{ \Carbon\Carbon::now()->format('Y') }}</p>
            <p>&copy; {{ \Carbon\Carbon::now()->format('Y') }} Sistem Absensi</p>
        </div>

    </div>
</body>

</html>
