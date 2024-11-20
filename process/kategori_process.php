<?php
include 'connection/connection.php';

$categories = [];

$query = "SHOW COLUMNS FROM produk LIKE 'kategori'";
$result = $konek->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $enumValues = $row['Type'];

    $enumValues = str_replace("enum(", "", $enumValues);
    $enumValues = str_replace(")", "", $enumValues);
    $enumValues = str_replace("'", "", $enumValues);
    $categories = explode(",", $enumValues);
} else {
    echo "Error fetching categories: " . $konek->error;
}

if (empty($categories)) {
    echo "No categories found or the array is empty.";
} else {
    echo "<!-- Categories retrieved: " . implode(", ", $categories) . " -->";
}
