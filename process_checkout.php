<?php
session_start();
include 'connection/connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    $konek->begin_transaction();

    try {
        $stmt = $konek->prepare("SELECT id_cart, id_produk, jumlah FROM cart WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_cart = $row['id_cart'];
                $id_produk = $row['id_produk'];
                $jumlah = $row['jumlah'];

                $stmt_product = $konek->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
                $stmt_product->bind_param("i", $id_produk);
                $stmt_product->execute();
                $product_result = $stmt_product->get_result();

                if ($product_result->num_rows > 0) {
                    $product = $product_result->fetch_assoc();
                    $harga = $product['harga'];
                    $stok = $product['stok'];

                    if ($stok >= $jumlah) {
                        $total_harga = $harga * $jumlah;

                        $stmt_order = $konek->prepare("INSERT INTO pembelian (id_user, id_produk, jumlah, total_harga, status) VALUES (?, ?, ?, ?, 'pending')");
                        $stmt_order->bind_param("iiid", $id_user, $id_produk, $jumlah, $total_harga);

                        if ($stmt_order->execute()) {
                            $new_stok = $stok - $jumlah;
                            $stmt_update_stock = $konek->prepare("UPDATE produk SET stok = ? WHERE id_produk = ?");
                            $stmt_update_stock->bind_param("ii", $new_stok, $id_produk);

                            if ($stmt_update_stock->execute()) {
                                $stmt_delete_cart = $konek->prepare("DELETE FROM cart WHERE id_cart = ?");
                                $stmt_delete_cart->bind_param("i", $id_cart);
                                $stmt_delete_cart->execute();
                            } else {
                                $konek->rollback();
                                throw new Exception("Error updating stock for product ID $id_produk.");
                            }
                        } else {
                            $konek->rollback();
                            throw new Exception("Error creating order for product ID $id_produk.");
                        }
                    } else {
                        $konek->rollback();
                        throw new Exception("Not enough stock for product ID $id_produk.");
                    }
                } else {
                    $konek->rollback();
                    throw new Exception("Product not found for ID $id_produk.");
                }
            }

            $konek->commit();

            header("Location: confirmation.php?message=" . urlencode("Order successfully placed."));
            exit();
        } else {
            $konek->rollback();
            echo "No items in your cart.";
            exit();
        }
    } catch (Exception $e) {
        $konek->rollback();
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: login.php?pesan=belum_login");
    exit();
}
