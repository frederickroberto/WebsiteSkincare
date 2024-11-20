<?php
session_start();
include 'connection/connection.php';

if (isset($_GET['id_cart'])) {
    $id_cart = $_GET['id_cart'];

    $stmt = $konek->prepare("DELETE FROM cart WHERE id_cart = ?");
    $stmt->bind_param("i", $id_cart);

    if ($stmt->execute()) {
        header("Location: cart.php?message=Item removed from cart.");
    } else {
        header("Location: cart.php?message=Error removing item from cart.");
    }

    $stmt->close();
} else {
    header("Location: cart.php");
}
