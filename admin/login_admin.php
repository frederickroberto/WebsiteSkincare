<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index_admin.php");
    exit();
}

if (isset($_GET['pesan'])) {
    $message = '';
    if ($_GET['pesan'] == "gagal") {
        $message = "Login gagal! Username dan password salah!";
    } else if ($_GET['pesan'] == "logout") {
        $message = "Anda telah berhasil logout.";
    } else if ($_GET['pesan'] == "belum_login") {
        $message = "Anda harus login untuk mengakses halaman admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="shortcut icon" href="assets/division.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../assets/bg2.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .login-card {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 2rem;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            border: none;
            color: #fff;
        }

        .role-btn {
            width: 50%;
            border-radius: 0;
        }

        .active-role {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            margin: 0 0.5rem;
            text-decoration: none;
        }

        .social-icons a:hover {
            color: #feb47b;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card login-card">
            <div class="card-body">
                <h1 class="text-center mb-4">Login as Admin</h1>

                <?php if (isset($message)): ?>
                    <div class="alert alert-warning text-center">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="process/login_admin_process.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="register_admin.php" class="link-primary">Register here</a></p>
                </div>
                <div class="social-icons text-center mt-4">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>