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
            width: 300px;
            height: 300px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">QR-CODE SISWA</h1>

        <!-- QR Code -->
        <div class="qr-code">
            {!! QrCode::size(300)->generate($token) !!}
            <h1 class="mt-5" id="countdown"></h1>
        </div>
       

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const countElement=document.getElementById('countdown');
            let duration=15
            const countdown=setInterval(() => {
                countElement.innerHTML=duration;
                duration--
                if (duration < 0) {
                    countElement.innerHTML='Token Expired';
                    clearInterval(countdown)
                    window.location.reload()
                    
                }
            }, 1000);
        </script>
</body>

</html>
