<?php
$message = isset($_GET['message']) ? $_GET['message'] : 'Unexpected error. Please contact support.';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Skincare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Order Confirmation</h2>

        <div class="alert alert-info text-center" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Return to Home</a>
        </div>
    </div>
</body>

</html>