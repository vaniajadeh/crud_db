<?php
include '../config.php';
$id = intval($_GET['id']);

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = floatval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $stmt = $conn->prepare("UPDATE products SET nama_produk=?, harga=?, stok=? WHERE id=?");
    $stmt->bind_param("sdii", $nama_produk, $harga, $stok, $id);

    if ($stmt->execute()) {
        header("Location: tabelproducts.php");
        exit();
    } else {
        echo "Gagal mengupdate produk: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Edit Produk</h2>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Produk:</label>
                    <input type="text" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga:</label>
                    <input type="number" step="0.01" name="harga" value="<?= $product['harga'] ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok:</label>
                    <input type="number" name="stok" value="<?= $product['stok'] ?>" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="tabelproducts.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>