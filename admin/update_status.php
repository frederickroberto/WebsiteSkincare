<?php
include '../connection/connection.php';

if (isset($_POST['id_pembelian'])) {
    $id_pembelian = $_POST['id_pembelian'];

    $query_get_date = "SELECT tanggal FROM pembelian WHERE id_pembelian = ?";
    $stmt_get_date = $konek->prepare($query_get_date);
    $stmt_get_date->bind_param("i", $id_pembelian);
    $stmt_get_date->execute();
    $result = $stmt_get_date->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tanggal_pembelian = $row['tanggal'];

        $query_update = "UPDATE pembelian SET status = 'done' WHERE tanggal = ?";
        $stmt_update = $konek->prepare($query_update);
        $stmt_update->bind_param("s", $tanggal_pembelian);

        if ($stmt_update->execute()) {
            echo "Status updated successfully for all purchases with the same date";
        } else {
            echo "Error updating status";
        }

        $stmt_update->close();
    } else {
        echo "No purchase found with the given ID";
    }

    $stmt_get_date->close();
} else {
    echo "ID pembelian not provided";
}
