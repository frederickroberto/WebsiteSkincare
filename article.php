<?php
session_start();
include 'process/kategori_process.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

include 'connection/connection.php';

$products = [];
$stmt = $konek->prepare("SELECT * FROM produk");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$konek->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - Skincare Tips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hero-section {
            background: url('./assets/skincare-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-section h1 {
            font-size: 3rem;
        }

        .article-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .article-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .article-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .hero-section {
            background: url('./assets/skincare-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-section h1 {
            font-size: 3rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Skincare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productDropdown">
                            <?php
                            if (empty($categories)) {
                                echo "<li><a class='dropdown-item' href='#'>No categories found</a></li>";
                            } else {
                                foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="product.php?category=<?php echo urlencode($category); ?>">
                                            <?php echo htmlspecialchars($category); ?>
                                        </a></li>
                            <?php endforeach;
                            } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="article.php">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorite.php">Favorite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <h1>Discover Skincare Tips</h1>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Latest Articles</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card article-card">
                    <img src="./assets/article1.jpg" class="card-img-top" alt="Article Image 1">
                    <div class="card-body">
                        <h5 class="card-title">How to Build a Skincare Routine</h5>
                        <p class="card-text">Learn the basics of creating a skincare routine for healthy and glowing skin. Perfect for beginners!</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card article-card">
                    <img src="./assets/article2.jpg" class="card-img-top" alt="Article Image 2">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Ingredients for Clear Skin</h5>
                        <p class="card-text">Discover the most effective skincare ingredients to combat acne and improve skin texture.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card article-card">
                    <img src="./assets/article3.jpg" class="card-img-top" alt="Article Image 3">
                    <div class="card-body">
                        <h5 class="card-title">Morning vs Night Skincare</h5>
                        <p class="card-text">Understand the differences between morning and night skincare routines and why both are essential.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4 bg-light mt-5">
        <p>&copy; 2024 Skincare. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>