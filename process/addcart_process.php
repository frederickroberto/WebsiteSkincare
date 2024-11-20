<?php
session_start();
include '../connection/connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You need to log in first.']);
    exit();
}

$id_user = $_SESSION['id_user'];
$id_produk = isset($_GET['id_produk']) ? intval($_GET['id_produk']) : 0;
$jumlah = isset($_GET['jumlah']) ? intval($_GET['jumlah']) : 1;

if ($jumlah < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quantity.']);
    exit();
}

$stmt = $konek->prepare("SELECT * FROM cart WHERE id_user = ? AND id_produk = ?");
$stmt->bind_param("ii", $id_user, $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $konek->prepare("UPDATE cart SET jumlah = jumlah + ? WHERE id_user = ? AND id_produk = ?");
    $stmt->bind_param("iii", $jumlah, $id_user, $id_produk);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product quantity updated in cart.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart.']);
    }
} else {
    $stmt = $konek->prepare("INSERT INTO cart (id_user, id_produk, jumlah) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id_user, $id_produk, $jumlah);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart.']);
    }
}

$stmt->close();
$konek->close();
