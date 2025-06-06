<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Log_form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND buyer_id = ? AND status = 'Menunggu Konfirmasi'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $delete->bind_param("i", $order_id);
        if ($delete->execute()) {
            $_SESSION['success'] = "Pesanan berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus pesanan.";
        }
    } else {
        $_SESSION['error'] = "Pesanan tidak ditemukan atau tidak bisa dihapus.";
    }
}

header("Location: pesanan.php");
exit();
