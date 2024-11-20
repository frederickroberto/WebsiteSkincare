<?php
include '../connection/connection.php';

$target_dir = "../uploads/";

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $query = "SELECT * FROM produk WHERE id_produk = ?";
    $stmt = $konek->prepare($query);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Produk tidak ditemukan'); window.location.href = 'edit_skincare.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID produk tidak ditemukan'); window.location.href = 'edit_skincare.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $merk = $_POST['merk'];
    $harga = $_POST['harga'];

    $foto = $row['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (getimagesize($_FILES['foto']['tmp_name']) === false) {
            echo "<script>alert('File yang diupload bukan gambar');</script>";
            exit();
        }

        if (file_exists($target_file)) {
            echo "<script>alert('Maaf, file sudah ada');</script>";
            exit();
        }

        if ($_FILES['foto']['size'] > 500000) {
            echo "<script>alert('Maaf, ukuran file terlalu besar');</script>";
            exit();
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan');</script>";
            exit();
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto = basename($_FILES['foto']['name']); // Nama file foto yang telah diupload
        } else {
            echo "<script>alert('Maaf, terjadi kesalahan saat mengupload file');</script>";
            exit();
        }
    }

    $update_query = "UPDATE produk SET nama = ?, kategori = ?, deskripsi = ?, stok = ?, foto = ?, merk = ?, harga = ? WHERE id_produk = ?";
    $stmt = $konek->prepare($update_query);
    $stmt->bind_param("sssissdi", $nama, $kategori, $deskripsi, $stok, $foto, $merk, $harga, $id_produk);

    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil diperbarui'); window.location.href = 'edit_skincare.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, produk gagal diperbarui');</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk</title>
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
                        <a class="nav-link" href="index_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="skincare.php">Skincare</a>
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
        <h1 class="text-center">Edit Produk Skincare</h1>

        <form method="POST" action="edit_produk.php?id=<?php echo $row['id_produk']; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $row['kategori']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $row['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $row['stok']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
            </div>
            <div class="mb-3">
                <label for="merk" class="form-label">Merk</label>
                <input type="text" class="form-control" id="merk" name="merk" value="<?php echo $row['merk']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $row['harga']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="edit_skincare.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>