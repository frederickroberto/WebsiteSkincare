<?php
include '../connection/connection.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $query_pembelian = "DELETE FROM pembelian WHERE id_produk = ?";
    $stmt_pembelian = $konek->prepare($query_pembelian);
    $stmt_pembelian->bind_param("i", $id_produk);
    $stmt_pembelian->execute();

    $query_produk = "DELETE FROM produk WHERE id_produk = ?";
    $stmt_produk = $konek->prepare($query_produk);
    $stmt_produk->bind_param("i", $id_produk);

    if ($stmt_produk->execute()) {
        echo "<script>alert('Produk berhasil dihapus'); window.location.href = 'edit_skincare.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, produk gagal dihapus'); window.location.href = 'edit_skincare.php';</script>";
    }
} else {
    echo "<script>alert('ID produk tidak ditemukan'); window.location.href = 'edit_skincare.php';</script>";
}
?>
