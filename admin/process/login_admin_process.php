<?php
session_start();
include '../../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $konek->prepare("SELECT id_admin, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_user, $db_username, $db_password);
        $stmt->fetch();

        if ($password == $db_password) {
            $_SESSION['logged_in'] = true;
            $_SESSION['id_admin'] = $id_admin;
            $_SESSION['username'] = $db_username;

            header("Location: ../index_admin.php");
            exit();
        } else {
            header("Location: ../login_admin.php?pesan=gagal");
            exit();
        }
    } else {
        header("Location: ../login_admin.php?pesan=gagal");
        exit();
    }

    $stmt->close();
    $konek->close();
}
