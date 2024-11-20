<?php
session_start();
include 'connection/connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

if (isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];
    $id_user = $_SESSION['id_user'];

    $stmt = $konek->prepare("DELETE FROM favorite WHERE id_user = ? AND id_produk = ?");
    $stmt->bind_param("ii", $id_user, $id_produk);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Product removed from favorites.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not remove the product.']);
    }

    $stmt->close();
    $konek->close();
}
