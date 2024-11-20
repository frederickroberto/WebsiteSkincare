<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

include 'connection/connection.php';
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

$products = [];
if ($selectedCategory) {
    $stmt = $konek->prepare("SELECT * FROM produk WHERE kategori = ?");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
}

$konek->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo htmlspecialchars($selectedCategory); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card-img-top {
            object-fit: contain;
            height: 250px;
            width: 100%;
            background-color: white;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
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
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-btn:hover {
            color: #e74c3c;
        }

        .product-title {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .product-card-body {
            position: relative;
            padding: 15px;
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

        .container {
            padding-top: 50px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-md-3 {
            margin-bottom: 30px;
        }

        h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 30px;
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

    <div class="container">
        <h2>Products in Category: <?php echo htmlspecialchars($selectedCategory); ?></h2>

        <?php if (empty($products)): ?>
            <p>No products found in this category.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="card product-card">
                            <a href="productdetail.php?id_produk=<?php echo $product['id_produk']; ?>&category=<?php echo urlencode($selectedCategory); ?>">
                                <img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                            </a>
                            <div class="card-body product-card-body">
                                <h6 class="text-muted"><?php echo htmlspecialchars($product['merk']); ?></h6>
                                <h5 class="card-title product-title"><?php echo htmlspecialchars($product['nama']); ?></h5>
                                <p class="product-price">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                                <a href="javascript:void(0);" class="add-to-cart-btn" data-id="<?php echo $product['id_produk']; ?>">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                                <a href="javascript:void(0);" class="favorite-btn" id="favorite-<?php echo $product['id_produk']; ?>">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id_produk = this.getAttribute('data-id'); // Ambil ID produk dari atribut data
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `addcart_process.php?id_produk=${id_produk}`, true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                alert(response.message); // Notifikasi sukses
                            } else {
                                alert(response.message); // Notifikasi error
                            }
                        } catch (e) {
                            console.error("Error parsing response:", e);
                            alert("An error occurred while adding to cart.");
                        }
                    }
                };

                xhr.send();
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.favorite-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.id.split('-')[1];
                    addToFavorites(productId);
                });
            });
        });

        function addToFavorites(id_produk) {
            fetch(`process/favorite_process.php?id_produk=${id_produk}`)
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
                .catch(error => console.error("Error:", error));
        }
    </script>
</body>

</html>