<?php
include '../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $konek->prepare("SELECT id_admin FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username already exists. Please choose another one.";
    } else {
        $stmt = $konek->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $success_message = "Registration successful! You can now <a href='login_admin.php'>login</a>.";
        } else {
            $error_message = "Error registering. Please try again later.";
        }
    }

    $stmt->close();
    $konek->close();
}
