<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: Log_form.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT name FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("User tidak ditemukan.");
}

$user = mysqli_fetch_assoc($result);
$name = $user['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lapak Desain</title>
  <link rel="stylesheet" href="main.css?v=1.0">
  <link rel="stylesheet" href="css/main.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <!-- navbar -->
   <?php include 'navbar.php'; ?>
 <!-- navbar -->

  <!-- Section 1 -->
  <section class="category-banner">
    <div class="overlay"></div>
    <div class="banner-content">
      <h2>High-Quality Design, Hassle-Free</h2>
      <p>Find trusted designers and get the perfect visuals for your needs—fast and easy.</p>
    </div>
  </section>

  <!-- Section 2 -->
  <section class="popular-categories container-xl">
    <h3 class="section-title">Most popular in Graphics & Design</h3>
    <div class="category-scroll">
      <a href="shop.php" class="category-card text-decoration-none"><div class="icon">🌱</div><span>Logo Design</span></a>
      <a href="shop.php" class="category-card text-decoration-none"><div class="icon">🎨</div><span>Illustration</span></a>
      <a href="shop.php" class="category-card text-decoration-none"><div class="icon">🏠</div><span>Business Card</span></a>
      <a href="shop.php" class="category-card text-decoration-none"><div class="icon">🧠</div><span>Social Media Design</span></a>
    </div>
  </section>

  <!-- Section 3 -->
  <section class="design-gallery container-xl">
    <h2 class="section-title">Guides To Help U</h2>
    <div class="design-grid">
      <div class="design-card">
        <div class="card-image"><img src="Images/desain1.jpeg" alt="Desain 1" /></div>
        <div class="card-text">
          <h3 class="card-title">Ilustrasi</h3>
          <p class="card-description">Menambah daya tarik visual pada konten pemasaran dan mempermudah penyampaian pesan bisnis secara kreatif dan informatif.</p>
        </div>
      </div>

      <div class="design-card">
        <div class="card-image"><img src="Images/desain2.jpeg" alt="Desain 2" /></div>
        <div class="card-text">
          <h3 class="card-title">Shutterstock Pricing Plans</h3>
          <p class="card-description">Tingkatkan proyek kreatif Anda dengan menggabungkan gambar, audio, dan video stok melalui paket harga Shutterstock yang fleksibel.</p>
        </div>
      </div>

      <div class="design-card">
        <div class="card-image"><img src="Images/desain3.jpeg" alt="Desain 3" /></div>
        <div class="card-text">
          <h3 class="card-title">Logo Design</h3>
          <p class="card-description">Membantu bisnis membangun identitas merek yang kuat dan mudah dikenali.</p>
        </div>
      </div>

      <div class="design-card">
        <div class="card-image"><img src="Images/desain4.jpeg" alt="Desain 4" /></div>
        <div class="card-text">
          <h3 class="card-title">What Is a Color Scheme?</h3>
          <p class="card-description">Pelajari jenis dan contoh skema warna untuk mendukung proyek desain visual Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace();</script>
</body>
</html>
