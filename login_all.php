<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['pesan'])) {
    $message = '';
    if ($_GET['pesan'] == "gagal") {
        $message = "Login gagal! Username dan password salah!";
    } else if ($_GET['pesan'] == "logout") {
        $message = "Anda telah berhasil logout.";
    } else if ($_GET['pesan'] == "belum_login") {
        $message = "Anda harus login untuk mengakses halaman selanjutnya.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/bg2.jpeg');
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
                <h1 class="text-center mb-4">Login</h1>

                <div class="d-flex mb-3">
                    <button id="userBtn" class="btn btn-outline-primary role-btn active-role">User</button>
                    <button id="adminBtn" class="btn btn-outline-primary role-btn">Admin</button>
                </div>

                <form id="loginForm" action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="register.php" class="link-primary">Register here</a></p>
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
    <script>
        document.getElementById("userBtn").addEventListener("click", function() {
            document.getElementById("loginForm").action = "login.php";
            document.getElementById("loginForm").submit();
        });

        document.getElementById("adminBtn").addEventListener("click", function() {
            document.getElementById("loginForm").action = "admin/login_admin.php";
            document.getElementById("loginForm").submit();
        });
    </script>
</body>

</html>