<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

$koneksi = mysqli_connect("localhost", "root", "", "feno");

// Add item to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1;

    // Get product details
    $query = "SELECT * FROM produk WHERE id='$id'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);

        // Add to cart
        $_SESSION['keranjang'][$id] = array(
            'nama' => $produk['nama'],
            'foto' => $produk['foto'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah
        );
    }
}

// Handle item deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Remove item from cart
    if (isset($_SESSION['keranjang'][$id])) {
        unset($_SESSION['keranjang'][$id]);
    }
}

// Display cart items
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
</head>
<body>
<header data-bs-theme="dark">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Carousel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          
        </form>
        <div class="nav-icon">
        <a href="#"><i class='bx bx-search-alt-2'></i></a>
        <a href="keranjang.php"><i class='bx bx-cart-add'></i></a>
      </div>
      </div>
    </div>
  </nav>
</header>

    <div class="container py-5">
        <h1 class="mb-4">Keranjang Anda</h1>

        <?php if (empty($_SESSION['keranjang'])): ?>
            <p>Keranjang Anda kosong.</p>
        <?php else: ?>
            <form method="post" action="checkout3.php">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['keranjang'] as $id => $item):
                            $subtotal = $item['harga'] * $item['jumlah'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><img src="image/<?= htmlspecialchars($item['foto']) ?>" width="100"></td>
                                <td><?= htmlspecialchars($item['nama']) ?></td>
                                <td>Rp. <?= number_format($item['harga']) ?></td>
                                <td><?= $item['jumlah'] ?></td>
                                <td>Rp. <?= number_format($subtotal) ?></td>
                                <td>
                                    <a href="keranjang.php?action=delete&id=<?= $id ?>" class="btn btn-danger btn-sm">DELETE</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>TOTAL</strong></td>
                            <td><strong>Rp. <?= number_format($total) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <input type="hidden" name="total" value="<?= $total ?>">
                <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                    <input type="hidden" name="keranjang[<?= $id ?>][nama]" value="<?= htmlspecialchars($item['nama']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][foto]" value="<?= htmlspecialchars($item['foto']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][harga]" value="<?= htmlspecialchars($item['harga']) ?>">
                    <input type="hidden" name="keranjang[<?= $id ?>][jumlah]" value="<?= htmlspecialchars($item['jumlah']) ?>">
                <?php endforeach; ?>
                <div class="d-flex justify-content-between mt-4">
    <a href="web.php" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i>Lanjut Belanja
    </a>
    <a href="checkout3.php" class="btn btn-primary">
        CHECKOUT <i class="fa fa-arrow-right"></i>
    </a>
</div>

            </form>
        <?php endif; ?>
    </div>
</body>
</html>