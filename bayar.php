<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Log_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? null;

$stmt = $conn->prepare("SELECT orders.id, projects.title, projects.price 
    FROM orders 
    JOIN projects ON orders.project_id = projects.id 
    WHERE orders.id = ? AND orders.buyer_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Data pesanan tidak ditemukan atau Anda tidak memiliki akses.");
}

// Simulasi pembayaran langsung (bisa dikembangkan untuk upload bukti)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'];

    // Simpan ke tabel payments
    $insert = $conn->prepare("INSERT INTO payments (order_id, user_id, amount, method, status, created_at) VALUES (?, ?, ?, ?, 'Lunas', NOW())");
    $insert->bind_param("iids", $order_id, $user_id, $order['price'], $method);
    $insert->execute();

    // Update status pembayaran di tabel orders
    $update = $conn->prepare("UPDATE orders SET status_pembayaran = 'Lunas' WHERE id = ?");
    $update->bind_param("i", $order_id);
    $update->execute();

    $_SESSION['success'] = "Pembayaran berhasil. Menunggu konfirmasi desainer.";
    header("Location: pesanan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">💳 Pembayaran</h2>

    <div class="card p-4">
        <h5>Project: <?= htmlspecialchars($order['title']) ?></h5>
        <p>Total: <strong>Rp <?= number_format($order['price'], 0, ',', '.') ?></strong></p>

        <form method="POST">
            <div class="mb-3">
                <label for="method" class="form-label">Metode Pembayaran</label>
                <select name="method" id="method" class="form-select" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Kartu Kredit">Kartu Kredit</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">💸 Bayar Sekarang</button>
        </form>
    </div>
</div>
</body>
</html>
