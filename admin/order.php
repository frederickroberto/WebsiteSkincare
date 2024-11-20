<?php
session_start();
include '../connection/connection.php';

$query = "SELECT pembelian.id_pembelian, user.username AS nama_user, produk.merk, produk.nama AS nama_produk, pembelian.jumlah, pembelian.total_harga, pembelian.status, pembelian.tanggal
          FROM pembelian
          JOIN user ON pembelian.id_user = user.id_user
          JOIN produk ON pembelian.id_produk = produk.id_produk
          WHERE pembelian.status = 'pending'
          ORDER BY pembelian.tanggal";
$result = $konek->query($query);

$orders = [];
while ($order = $result->fetch_assoc()) {
    $tanggal = $order['tanggal'];
    $nama_user = $order['nama_user'];
    $id_pembelian = $order['id_pembelian'];

    $key = $nama_user . '_' . $tanggal;

    if (!isset($orders[$key])) {
        $orders[$key] = [
            'nama_user' => $nama_user,
            'tanggal' => $tanggal,
            'id_pembelian' => $id_pembelian,
            'products' => []
        ];
    }

    $orders[$key]['products'][] = [
        'nama_produk' => $order['nama_produk'],
        'jumlah' => $order['jumlah'],
        'total_harga' => $order['total_harga']
    ];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="text-center">All Orders</h2>

        <?php if (!empty($orders)): ?>
            <div class="row">
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">User: <?php echo htmlspecialchars($order['nama_user']); ?></h5>
                                <p class="card-text">Date: <?php echo htmlspecialchars($order['tanggal']); ?></p>
                                <button class="btn btn-primary" onclick="showReceiptModal(
                    '<?php echo htmlspecialchars($order['nama_user']); ?>',
                    <?php echo htmlspecialchars(json_encode($order['products'])); ?>,
                    '<?php echo htmlspecialchars($order['tanggal']); ?>',
                    <?php echo htmlspecialchars($order['id_pembelian']); ?>
                )">Print Receipt</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Order Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="receiptContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printReceipt()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showReceiptModal(namaUser, products, tanggalPembelian, idPembelian) {
            let receiptContent = `<p><strong>User:</strong> ${namaUser}</p>`;
            receiptContent += `<p><strong>Date:</strong> ${tanggalPembelian}</p>`;
            receiptContent += `<table class="table">
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Quantity</th>
                                  <th>Total Price</th>
                              </tr>
                          </thead>
                          <tbody>`;

            let totalHargaKeseluruhan = 0;

            products.forEach(product => {
                receiptContent += `<tr>
                              <td>${product.nama_produk}</td>
                              <td>${product.jumlah}</td>
                              <td>Rp ${Number(product.total_harga).toLocaleString('id-ID')}</td>
                           </tr>`;
                totalHargaKeseluruhan += parseInt(product.total_harga);
            });

            receiptContent += `</tbody></table>`;
            receiptContent += `<p><strong>Total Harga: Rp ${totalHargaKeseluruhan.toLocaleString('id-ID')}</strong></p>`;

            document.getElementById('receiptContent').innerHTML = receiptContent;

            currentOrderId = idPembelian;

            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            receiptModal.show();
        }

        function printReceipt() {
            const receiptContent = document.getElementById('receiptContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Order Receipt</title></head><body>');
            printWindow.document.write('<h1>Order Receipt</h1>');
            printWindow.document.write(receiptContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();

            updateOrderStatus();
        }

        function updateOrderStatus() {
            if (currentOrderId) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "update_status.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const receiptModal = bootstrap.Modal.getInstance(document.getElementById('receiptModal'));
                        receiptModal.hide();
                        location.reload();
                    }
                };
                xhr.send("id_pembelian=" + currentOrderId);
            }
        }
    </script>
</body>

</html>