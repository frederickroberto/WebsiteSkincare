<?php
include '../connection/connection.php';

$query = "SELECT * FROM produk";
$result = $konek->query($query);

$query_enum = "SHOW COLUMNS FROM produk LIKE 'kategori'";
$result_enum = $konek->query($query_enum);
$enum_values = [];

if ($row_enum = $result_enum->fetch_assoc()) {
    preg_match_all("/'([^']+)'/", $row_enum['Type'], $matches);
    $enum_values = $matches[1];
}

$kategori_filter = '';
if (isset($_GET['kategori'])) {
    $kategori_filter = $_GET['kategori'];
    $query = "SELECT * FROM produk WHERE kategori = '$kategori_filter'";
    $result = $konek->query($query);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Skincare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="skincare.php">Skincare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">Order</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Edit Skincare Products</h1>

        <form action="" method="GET" class="d-flex mb-3">
            <select name="kategori" class="form-select" aria-label="Kategori" onchange="this.form.submit()">
                <option value="">Pilih Kategori</option>
                <?php foreach ($enum_values as $value): ?>
                    <option value="<?php echo $value; ?>" <?php echo ($kategori_filter == $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Merk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['kategori']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td><?php echo $row['merk']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                        <td>
                            <div class="d-flex">
                                <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                <a href="delete_produk.php?id=<?php echo $row['id_produk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>