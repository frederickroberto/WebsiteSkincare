<?php
session_start();
include 'connection/connection.php';
include 'process/kategori_process.php';


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}


if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    $stmt = $konek->prepare("SELECT cart.id_cart, produk.id_produk, produk.nama, produk.harga, produk.foto, cart.jumlah 
    FROM cart INNER JOIN produk ON cart.id_produk = produk.id_produk 
    WHERE cart.id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Skincare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
        }

        .cart-item img {
            max-width: 80px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .cart-item-info {
            flex: 2;
        }

        .cart-item p {
            margin: 0;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .cart-item .original-price {
            text-decoration: line-through;
            color: #aaa;
            margin-right: 5px;
        }

        .cart-item .discounted-price {
            color: #000;
            font-size: 1rem;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
        }

        .quantity-container input[type="number"] {
            width: 60px;
            text-align: center;
        }

        .subtotal-price {
            flex: 1;
            color: #ff5722;
            font-size: 1.2rem;
            text-align: right;
        }

        .remove-btn {
            flex: 0;
            margin-left: 10px;
        }

        .cart-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-weight: bold;
        }

        .cart-footer .total {
            font-size: 1.5rem;
            color: #2d3e50;
        }

        .btn-custom {
            background-color: #ff5722;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e64a19;
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
                        <a class="nav-link" href="article.php">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorite.php">Favorite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php">Cart</a>
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

    <div class="container my-5">
        <h2 class="text-center mb-4">Your Cart</h2>

        <?php
        $totalPrice = 0;
        if ($result->num_rows > 0): ?>
            <div class="cart-items">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="cart-item">
                        <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">

                        <div class="cart-item-info">
                            <p><?php echo htmlspecialchars($row['nama']); ?></p>
                            <p>
                                <span class="discounted-price">Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                            </p>
                        </div>

                        <div class="quantity-container">
                            <button onclick="updateQuantity(this, -1)" data-id-cart="<?php echo $row['id_cart']; ?>">-</button>
                            <input type="number" class="form-control" value="<?php echo $row['jumlah']; ?>" min="1" step="1" data-id-cart="<?php echo $row['id_cart']; ?>" data-harga="<?php echo $row['harga']; ?>" onchange="updateCart(this)">
                            <button onclick="updateQuantity(this, 1)" data-id-cart="<?php echo $row['id_cart']; ?>">+</button>
                        </div>

                        <div class="subtotal-price">
                            Rp <span class="subtotal"><?php echo number_format($row['harga'] * $row['jumlah'], 0, '.', '.'); ?></span>
                        </div>

                        <a href="remove_cart.php?id_cart=<?php echo $row['id_cart']; ?>" class="btn btn-danger btn-sm remove-btn" onclick="return confirmRemove(this);">Remove</a>
                    </div>

                    <?php $totalPrice += $row['harga'] * $row['jumlah']; ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
            <div class="text-center">
                <button class="btn btn-primary" onclick="window.location.href='product.php';">Browse Products</button>
            </div>

        <?php endif; ?>

        <div class="cart-footer">
            <p>Total:</p>
            <p class="total">Rp <?php echo number_format($totalPrice, 0, ',', '.'); ?></p>
        </div>

        <div class="text-center mt-4">
            <a href="checkout.php" class="btn btn-custom btn-lg">Proceed to Checkout</a>
        </div>
    </div>

    <script>
        function updateQuantity(button, change) {
            const input = button.parentNode.querySelector("input");
            input.value = Math.max(parseInt(input.value) + change, 1);
            updateCart(input);
        }

        function updateCart(element) {
            const id_cart = element.getAttribute("data-id-cart");
            let jumlah = parseInt(element.value);
            if (isNaN(jumlah) || jumlah < 1) jumlah = 1;

            const harga = element.getAttribute("data-harga");
            const subtotal = harga * jumlah;
            element.closest('.cart-item').querySelector('.subtotal').textContent = subtotal.toLocaleString();

            updateTotal();

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log('Cart updated successfully');
                    } else {
                        console.error('Error updating cart:', response.message);
                    }
                }
            };
            xhr.send("id_cart=" + id_cart + "&jumlah=" + jumlah);
        }

        function updateTotal() {
            let totalPrice = 0;
            document.querySelectorAll('.subtotal').forEach(function(subtotalElem) {
                const subtotal = parseInt(subtotalElem.textContent.replace(/\D/g, ''));
                totalPrice += subtotal;
            });
            document.querySelector('.total').textContent = 'Rp ' + totalPrice.toLocaleString();
        }

        function confirmRemove(button) {
            const confirmDelete = window.confirm("Are you sure you want to remove this item from your cart?");

            if (confirmDelete) {
                window.location.href = button.href;
            }

            return false;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>