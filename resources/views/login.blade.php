<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #3a3a52, #1d1d2c);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .profile-icon {
            background: rgba(0, 0, 0, 0.2);
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
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 5px;
            color: #fff;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-primary {
            background: #6a11cb;
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
            color: rgba(255, 255, 255, 0.8);
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
