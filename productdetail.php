<?php
include 'process/kategori_process.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];
?>

<?php
include 'connection/connection.php';

$productId = isset($_GET['id_produk']) ? $_GET['id_produk'] : 0;

$product = null;
if ($productId) {
    $stmt = $konek->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;

    $stmt = $konek->prepare("SELECT harga FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $harga = $product['harga'];
    $totalHarga = $harga * $jumlah;

    $stmt = $konek->prepare("SELECT * FROM cart WHERE id_user = ? AND id_produk = ?");
    $stmt->bind_param("ii", $id_user, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItem = $result->fetch_assoc();

    if ($cartItem) {
        $newJumlah = $cartItem['jumlah'] + $jumlah;
        $newTotalHarga = $harga * $newJumlah;

        $stmt = $konek->prepare("UPDATE cart SET jumlah = ?, total_harga = ? WHERE id_user = ? AND id_produk = ?");
        $stmt->bind_param("idii", $newJumlah, $newTotalHarga, $id_user, $productId);
        $stmt->execute();
    } else {
        $stmt = $konek->prepare("INSERT INTO cart (id_user, id_produk, jumlah, total_harga) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_user, $productId, $jumlah, $totalHarga);
        $stmt->execute();
    }

    $stmt->close();
    $konek->close();

    header("Location: cart.php");
    exit();
}

$konek->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo htmlspecialchars($product['nama']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .row {
            margin-top: 0;
        }

        .col-md-6 img {
            max-width: 100%;
            height: auto;
        }

        .col-md-6 {
            padding: 0;
        }

        .product-details p {
            margin-bottom: 0.5rem;
        }

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

        .alert {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 999;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            max-width: 300px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #e74c3c;
            color: white;
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
                        <a class="nav-link dropdown-toggle active" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="container mt-5">
        <?php if ($product): ?>
            <h2><?php echo htmlspecialchars($product['nama']); ?></h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="img-fluid w-50" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                </div>
                <div class="col-md-6">
                    <h3>Details</h3>
                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['merk']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['deskripsi']); ?></p>
                    <p><strong>Price:</strong> Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                    <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['stok']); ?></p>

                    <form action="cart.php" method="post">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Quantity</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" max="<?php echo $product['stok']; ?>" value="1" required>
                        </div>
                        <input type="hidden" name="id_produk" value="<?php echo $product['id_produk']; ?>">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <a href="javascript:void(0);" class="add-to-cart-btn" data-id="<?php echo $product['id_produk']; ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </a>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>

        <a href="index.php?category=<?php echo urlencode($selectedCategory); ?>" class="btn btn-primary mt-4">Back to Products</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-id');
                    addToCart(productId);
                });
            });
        });

        function addToCart(id_produk) {
            fetch(`process/addcart_process.php?id_produk=${id_produk}`)
                .then(response => response.json())
                .then(data => {
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
                .catch(error => {
                    console.error("Error:", error);
                });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>