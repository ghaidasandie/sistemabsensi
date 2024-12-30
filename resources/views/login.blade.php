<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #d9ebff, #7292af);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333; /* Warna teks utama lebih gelap */
        }
    
        .login-container {
            background: rgba(255, 255, 255, 0.8); /* Warna latar lebih terang untuk kontras */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: #333; /* Warna teks dalam kontainer lebih gelap */
        }
    
        .profile-icon {
            background: #075d96; /* Warna solid untuk ikon profil */
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            color: #fff;
        }
    
        .form-control {
            background: rgba(255, 255, 255, 0.9); /* Warna latar input lebih terang */
            border: 1px solid #ccc; /* Border input untuk tampilan lebih jelas */
            border-radius: 5px;
            color: #333; /* Warna teks dalam input */
        }
    
        .form-control::placeholder {
            color: #999; /* Placeholder lebih jelas */
        }
    
        .btn-primary {
            background: #075d96;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            padding: 10px 0;
            transition: background 0.3s;
        }
    
        .btn-primary:hover {
            background: #2575fc;
        }
    
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #333; /* Warna teks lebih gelap */
        }
    
        label {
            color: #333; /* Warna label lebih gelap */
        }
    </style>
    
</head>
<body>
    <div class="login-container">
        <div class="profile-icon">
            <i class="bi bi-person"></i>
        </div>
        <h3 class="mb-4">Login</h3>
        <form action="login" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="remember-forgot mb-3">
                <div>
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
