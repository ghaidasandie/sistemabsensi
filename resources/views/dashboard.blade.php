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
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Your content goes here -->
        <h1>Welcome to Data Siswa</h1>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
