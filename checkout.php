<?php
session_start();
include 'connection/connection.php';

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
} else {
    echo "No user found in session.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="favorite.php">Favorite</a>
                    </li>
                    <li class="nav-item active">
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
        <h2 class="text-center mb-4">Checkout</h2>

        <?php if (isset($result) && $result->num_rows > 0): ?>
            <div class="checkout-items">
                <?php $totalPrice = 0; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="cart-item">
                        <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>" style="max-width: 100px;">
                        <div>
                            <p><strong><?php echo htmlspecialchars($row['nama']); ?></strong></p>
                            <p>Price: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?> x <?php echo $row['jumlah']; ?></p>
                            <p>Subtotal: Rp <?php echo number_format($row['harga'] * $row['jumlah'], 0, '.', '.'); ?></p>
                        </div>
                    </div>

                    <?php $totalPrice += $row['harga'] * $row['jumlah']; ?>
                <?php endwhile; ?>
            </div>

            <div class="text-center mt-3">
                <p><strong>Total: Rp <?php echo number_format($totalPrice, 0, ',', '.'); ?></strong></p>
                <a href="process_checkout.php" class="btn btn-primary btn-lg">Proceed to Payment</a>
            </div>

        <?php else: ?>
            <p class="text-center">No products in your cart to checkout. <a href="product.php">Browse Products</a></p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>