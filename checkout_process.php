<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $total_price = $_POST['total_price'];
    $order_status = 'pending';

    $konek->begin_transaction();

    $order_query = "INSERT INTO orders (user_id, total_harga, order_status) VALUES (?, ?, ?)";
    $stmt = $konek->prepare($order_query);
    $stmt->bind_param("iss", $user_id, $total_price, $order_status);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        $update_cart_query = "UPDATE cart SET order_id = ? WHERE user_id = ?";
        $update_stmt = $konek->prepare($update_cart_query);
        $update_stmt->bind_param("ii", $order_id, $user_id);

        if ($update_stmt->execute()) {
            $konek->commit();

            header("Location: confirmation.php?message=" . urlencode("Order successfully placed."));
            exit();
        } else {
            $konek->rollback();
            header("Location: confirmation.php?status=failure");
            exit();
        }
    } else {
        $konek->rollback();
        header("Location: confirmation.php?status=failure");
        exit();
    }
}
