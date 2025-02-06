<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .section-separator {
            margin-top: 40px;
            border-top: 3px solid #ddd;
            margin-bottom: 40px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Flatpickr Custom Styles */
        .flatpickr-input {
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .flatpickr-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Menu</h3>
        <div class="menu">
            <a href="/dashboard">Dashboard</a>
            <a href="/siswa">Data Siswa</a>
            <a href="/absensi">Data Absensi</a>
            <a href="/status" class="active">Status</a>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Status Absensi</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('status.update', $status->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Status Absensi</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="offline" {{ ($status->status ?? 'offline') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ ($status->status ?? 'offline') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @error('status')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mulai" class="form-label">Waktu Mulai</label>
                    <input type="text" id="mulai" name="mulai" class="form-control timepicker flatpickr-input" value="{{ old('mulai', $status->mulai ?? '') }}">
                    @error('mulai')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="selesai" class="form-label">Waktu Selesai</label>
                    <input type="text" id="selesai" name="selesai" class="form-control timepicker flatpickr-input" value="{{ old('selesai', $status->selesai ?? '') }}">
                    @error('selesai')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const statusSelect = document.getElementById('status');
        const waktuFields = [document.getElementById('mulai'), document.getElementById('selesai')];

        // Flatpickr untuk input waktu
        flatpickr('.timepicker', {
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i",  // Format waktu 24 jam (misal 00:01)
            minuteIncrement: 5, // Increment menit setiap 5 menit
        });

        function toggleWaktuFields() {
            const isOnline = statusSelect.value === 'online';
            waktuFields.forEach(field => field.disabled = !isOnline);
        }

        statusSelect.addEventListener('change', toggleWaktuFields);
        toggleWaktuFields(); // Update status saat pertama kali loading halaman
    </script>
</body>

</html>
