<?php
session_start();
include 'connection/connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You need to log in first.']);
    exit();
}

$id_cart = isset($_POST['id_cart']) ? intval($_POST['id_cart']) : 0;
$jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1;

if ($id_cart && $jumlah > 0) {
    $stmt = $konek->prepare("UPDATE cart SET jumlah = ? WHERE id_cart = ?");
    $stmt->bind_param("ii", $jumlah, $id_cart);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
}

$konek->close();
