<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Log_form.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Ambil project jika sudah ada
$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$has_uploaded = $result->num_rows > 0;
$project = $has_uploaded ? $result->fetch_assoc() : null;

// Hapus project jika diminta
if (isset($_POST['delete'])) {
    $deleteStmt = $conn->prepare("DELETE FROM projects WHERE user_id = ?");
    $deleteStmt->bind_param("i", $user_id);
    $deleteStmt->execute();
    echo '<div class="alert alert-success text-center">Project berhasil dihapus!</div>';
    $has_uploaded = false;
    $project = null;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Upload Project</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" required value="<?= $project['title'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (Rupiah)</label>
            <input type="number" name="price" class="form-control" step="0.01" required value="<?= $project['price'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" required><?= $project['description'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <?php if ($has_uploaded && $project['image']): ?>
                <p class="mt-2">Gambar saat ini:</p>
                <img src="uploads/<?= $project['image'] ?>" width="150">
            <?php endif; ?>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" name="<?= $has_uploaded ? 'update' : 'submit' ?>" class="btn btn-<?= $has_uploaded ? 'primary' : 'success' ?>">
                <?= $has_uploaded ? 'Update Project' : 'Upload Project' ?>
            </button>
            <?php if ($has_uploaded): ?>
                <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus project ini?')">Hapus Project</button>
            <?php endif; ?>
            <a href="profil.php" class="btn btn-secondary">Kembali ke Profil</a>
        </div>
    </form>

    <?php
    // Upload baru
    if (isset($_POST['submit']) && !$has_uploaded) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $imageName = basename($_FILES['image']['name']);
        $target = 'uploads/' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $insert = $conn->prepare("INSERT INTO projects (user_id, title, price, description, image) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("isdss", $user_id, $title, $price, $description, $imageName);
            $insert->execute();
            echo '<div class="alert alert-success mt-3">Upload berhasil!</div>';
        } else {
            echo '<div class="alert alert-danger mt-3">Gagal mengupload gambar!</div>';
        }
    }

    // Update project
    if (isset($_POST['update']) && $has_uploaded) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $imageName = $project['image']; // default image lama

        // Jika user mengupload gambar baru
        if (!empty($_FILES['image']['name'])) {
            $newImage = basename($_FILES['image']['name']);
            $target = 'uploads/' . $newImage;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imageName = $newImage;
            }
        }

        $update = $conn->prepare("UPDATE projects SET title = ?, price = ?, description = ?, image = ? WHERE user_id = ?");
        $update->bind_param("sdssi", $title, $price, $description, $imageName, $user_id);
        $update->execute();
        echo '<div class="alert alert-success mt-3">Project berhasil diperbarui!</div>';
    }
    ?>
</div>
</body>
</html>
