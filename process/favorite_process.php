<?php
session_start();
include '../connection/connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You need to log in first.']);
    exit();
}

$id_user = $_SESSION['id_user'];
$id_produk = isset($_GET['id_produk']) ? intval($_GET['id_produk']) : 0;

$checkProductStmt = $konek->prepare("SELECT id_produk FROM produk WHERE id_produk = ?");
$checkProductStmt->bind_param("i", $id_produk);
$checkProductStmt->execute();
$productCheckResult = $checkProductStmt->get_result();

if ($productCheckResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Product does not exist.']);
    $checkProductStmt->close();
    $konek->close();
    exit();
}

$checkProductStmt->close();

$stmt = $konek->prepare("SELECT * FROM favorite WHERE id_user = ? AND id_produk = ?");
$stmt->bind_param("ii", $id_user, $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Product is already in favorites.']);
    $stmt->close();
    $konek->close();
    exit();
}

$stmt = $konek->prepare("INSERT INTO favorite (id_user, id_produk) VALUES (?, ?)");
$stmt->bind_param("ii", $id_user, $id_produk);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Added to favorites.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add to favorites.']);
}

$stmt->close();
$konek->close();
