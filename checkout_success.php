<?php
session_start();
include 'connection/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $konek->prepare("SELECT * FROM pembelian WHERE id_user = ? ORDER BY id_pembelian DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$transaksi = $result->fetch_assoc();

if (!$transaksi) {
    echo "Tidak ada transaksi ditemukan.";
    exit();
}

$stmt_detail = $konek->prepare("SELECT p.nama_produk, td.jumlah, p.harga FROM transaksi_detail td JOIN produk p ON td.id_produk = p.id_produk WHERE td.transaksi_id = ?");
$stmt_detail->bind_param("i", $transaksi['id_pembelian']);
$stmt_detail->execute();
$details = $stmt_detail->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Sukses</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>

<body>
    <div class="container">
        <h1>Checkout Sukses!</h1>
        <p>Terima kasih telah berbelanja! Transaksi Anda berhasil dilakukan.</p>

        <h3>Detail Transaksi</h3>
        <p><strong>ID Pembelian:</strong> <?php echo $transaksi['id_pembelian']; ?></p>
        <p><strong>Total Harga:</strong> Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></p>

        <h4>Daftar Produk:</h4>
        <ul>
            <?php while ($item = $details->fetch_assoc()) { ?>
                <li>
                    <?php echo $item['nama_produk']; ?> (Jumlah: <?php echo $item['jumlah']; ?>) - Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                </li>
            <?php } ?>
        </ul>

        <p>Status Pembelian: <?php echo ucfirst($transaksi['status']); ?></p>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>

</html>