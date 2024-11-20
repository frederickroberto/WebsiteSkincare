<?php
session_start();

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
    <title>All Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hero {
            height: 80vh;
            background: url('./assets/bg3.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .card-img-top {
            object-fit: contain;
            height: 250px;
            width: 100%;
            background-color: white;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }

        .add-to-cart-btn {
            background-color: #28a745;
            color: white;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .add-to-cart-btn:hover {
            background-color: #218838;
            color: white;
        }

        .alert {
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 15px;
            z-index: 1000;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .alert-success {
            background-color: #28a745;
        }

        .alert-danger {
            background-color: #dc3545;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5em;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-btn:hover {
            color: #e74c3c;
        }

        .search-btn {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php
    include 'process/kategori_process.php';
    ?>

    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Skincare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
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
                        <a class="nav-link" href="article.php">Article</a>
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

    <div class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="display-4">Nurture Your Skin, Naturally</h1>
            <p class="lead">Discover the beauty of healthy skin with our premium skincare products.</p>
            <a href="#products" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>

    <div class="container mt-5" id="products">
        <h2>All Products</h2>

        <form action="search_product.php" method="get" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or brand"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>


        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="card product-card mb-4">
                            <a href="productdetail.php?id_produk=<?php echo $product['id_produk']; ?>">
                                <img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                            </a>
                            <div class="card-body">
                                <h6 class="text-muted"><?php echo htmlspecialchars($product['merk']); ?></h6>
                                <h5 class="card-title"><?php echo htmlspecialchars($product['nama']); ?></h5>
                                <p class="product-price">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                                <a href="javascript:void(0);" class="add-to-cart-btn" onclick="addToCart(<?php echo $product['id_produk']; ?>)">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                                <a href="javascript:void(0);" class="favorite-btn" id="favorite-<?php echo $product['id_produk']; ?>" onclick="addToFavorites(<?php echo $product['id_produk']; ?>)">
                                    <i class="fas fa-heart"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.favorite-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.id.split('-')[1];
                    addToFavorites(productId);
                });
            });
        });

        function addToFavorites(id_produk) {
    console.log(`Attempting to add product ID: ${id_produk}`); // Debugging

    fetch(`process/favorite_process.php?id_produk=${id_produk}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Debugging response
            const notification = document.createElement("div");
            notification.className = "alert";
            notification.textContent = data.message;

            if (data.status === "success") {
                notification.classList.add("alert-success");
            } else {
                notification.classList.add("alert-danger");
            }

            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        })
        .catch(error => console.error("Error:", error));
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>