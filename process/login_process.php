<?php
session_start();
include '../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $konek->prepare("SELECT id_user, username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_user, $db_username, $db_password);
        $stmt->fetch();

        if ($password == $db_password) {
            $_SESSION['logged_in'] = true;
            $_SESSION['id_user'] = $id_user;
            $_SESSION['username'] = $db_username;

            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?pesan=gagal");
            exit();
        }
    } else {
        header("Location: ../login.php?pesan=gagal");
        exit();
    }

    $stmt->close();
    $konek->close();
}
