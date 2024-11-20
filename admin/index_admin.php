<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('./assets/dashboard-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #333;
        }

        .hero-section {
            background: url('../assets/dashboard-bg.jpg') no-repeat center center;
            background-size: cover;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .lead {
            color: #ddd;
        }

        a.text-decoration-none:hover {
            text-decoration: underline;
        }

        .hero-text h1,
        .hero-text .lead {
            color: black;
            text-shadow: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="skincare.php">Skincare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">Order</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <h1>Welcome to Skincare Dashboard</h1>
    </header>

    <div class="container mt-5">
        <div class="text-center hero-text">
            <h1 class="mb-3">Manage Your Skincare Products</h1>
            <p class="lead">Easily manage product listings, update inventory, and monitor orders.</p>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <a href="skincare.php" class="text-decoration-none">
                    <div class="card p-3" style="background-image: url('../assets/admin1.jpg'); background-size: cover; background-position: center; height: 200px; color: white; border-radius: 10px;">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            <h5 class="card-title">Skincare</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="edit_skincare.php" class="text-decoration-none">
                    <div class="card p-3" style="background-image: url('../assets/admin2.jpg'); background-size: cover; background-position: center; height: 200px; color: white; border-radius: 10px;">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            <h5 class="card-title">Edit Skincare</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="order.php" class="text-decoration-none">
                    <div class="card p-3" style="background-image: url('../assets/admin3.jpg'); background-size: cover; background-position: center; height: 200px; color: white; border-radius: 10px;">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            <h5 class="card-title">Order</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>