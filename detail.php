<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Barang</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100%; /* Ensure the image is responsive */
            height: auto; /* Maintain aspect ratio */
        }
        .related-products img {
            max-height: 200px; /* Set a max height for related product images */
            object-fit: cover; /* Ensure images cover the area without distortion */
            width: 100%; /* Ensure images are responsive */
        }
    </style>
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
        <a href="profil2.php"><i class='bx bx-user' ></i></a>
      </div>
      </div>
    </div>
  </nav>
</header>

<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <?php
            session_start();
            $koneksi = mysqli_connect("localhost", "root", "", "feno");

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = mysqli_real_escape_string($koneksi, $_GET['id']);
                $query = "SELECT * FROM produk WHERE id='$id'";
                $result = mysqli_query($koneksi, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($produk = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-5">
                            <img class="product-image" src="image/<?= htmlspecialchars($produk['foto']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>">
                        </div>
                        <div class="col-md-6 offset-md-1">
                            <h1><b><?= htmlspecialchars($produk['nama']) ?></b></h1>
                            <h3><?= htmlspecialchars($produk['deskripsi']) ?></h3><br>
                            <h2 class="text-red"><b>Rp. <?= number_format($produk['harga']) ?></b></h2><br>
                            <form method="post" action="keranjang.php?action=add">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($produk['id']) ?>">
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <input type="number" min="1" value="1" class="form-control" name="jumlah">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-auto">ADD TO CART</button>
                            </form><br>
                        </div>
                        <?php
                    }
                }
            }
            mysqli_close($koneksi);
            ?>
        </div>
    </div>
</div>

<div class="container-fluid py-5 bg-light text-center mb-5">
    <div class="container">
        <h2 class="text-center text-black mb-5">Related products</h2>
    </div>
</div>

<div class="container px-4 px-lg-5 mt-5 related-products">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php
        $koneksi = mysqli_connect("localhost", "root", "", "feno");
        $query = "SELECT * FROM produk";
        $result = mysqli_query($koneksi, $query);
        while ($produk = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <img class="card-img-top" src="image/<?= htmlspecialchars($produk['foto']) ?>" />
                    <div class="card-body p-4">
                        <p class="text-center"><b><?= htmlspecialchars($produk['nama']) ?></b></p>
                        <p><?= htmlspecialchars($produk['deskripsi']) ?></p>
                        <p><b>Rp. <?= number_format($produk['harga']) ?></b></p>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="detail.php?id=<?= $produk['id'] ?>">DETAILS</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        mysqli_close($koneksi);
        ?>
    </div>
</div>
</body>
</html>