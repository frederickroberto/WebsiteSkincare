<?php
session_start();
include 'connection/connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$id_user = $_SESSION['id_user'];

$stmt = $konek->prepare("
    SELECT produk.id_produk, produk.merk, produk.nama, produk.harga, produk.foto 
    FROM favorite 
    JOIN produk ON favorite.id_produk = produk.id_produk 
    WHERE favorite.id_user = ?
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = $row;
}

$stmt->close();
$konek->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        .add-to-cart-btn {
            background-color: #28a745;
            color: white;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: #218838;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5em;
            color: red;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .favorite-btn:hover {
            color: #e74c3c;
        }

        .card-body {
            position: relative;
        }

        .product-title {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>

<body>
    <?php
    include 'process/kategori_process.php';
    ?>

    <div id="notification" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        Product successfully removed from favorites.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
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
                        <a class="nav-link" href="article.php">Article</a>
                    </li>
                    <li class="nav-item active">
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

    <div class="container mt-5">
        <h2>Your Favorite Products</h2>
        <?php if (empty($favorites)): ?>
            <p>You have no favorite products.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($favorites as $favorite): ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="uploads/<?php echo htmlspecialchars($favorite['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($favorite['nama']); ?>">
                            <div class="card-body">
                                <h6 class="text-muted"><?php echo htmlspecialchars($favorite['merk']); ?></h6>
                                <h5 class="card-title product-title"><?php echo htmlspecialchars($favorite['nama']); ?></h5>
                                <p class="product-price">Rp <?php echo number_format($favorite['harga'], 0, ',', '.'); ?></p>
                                <a href="javascript:void(0);" class="add-to-cart-btn" data-id="<?php echo $favorite['id_produk']; ?>">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>

                                <a href="javascript:void(0);" class="favorite-btn" id="favorite-<?php echo $favorite['id_produk']; ?>" onclick="removeFavorite(<?php echo $favorite['id_produk']; ?>)">
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
        function removeFavorite(id_produk) {
            const confirmDelete = window.confirm("Are you sure you want to remove this product from your favorites?");
            if (confirmDelete) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "remove_favorite.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById("notification").style.display = "block";

                        setTimeout(function() {
                            document.getElementById("notification").style.display = "none";
                        }, 3000);

                        location.reload();
                    } else {
                        alert("Error: Could not remove product.");
                    }
                };
                xhr.send("id_produk=" + id_produk);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>