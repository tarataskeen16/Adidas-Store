<?php
session_start();
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Taskeen'; // Ambil nama dari sesi jika ada
$tanggal = date('Y-m-d'); // Tanggal pembelian saat ini
$id_transaksi = 'INV-' . date('Ymd') . '-' . rand(1000, 9999); // Nomor invoice otomatis

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "feno");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Nota Pembelian</h1>
        <div class="mb-4">
            <p><strong>Nomor Invoice:</strong> <?php echo $id_transaksi; ?></p>
            <p><strong>Nama Pembeli:</strong> <?php echo htmlspecialchars($nama); ?></p>
            <p><strong>Tanggal Pembelian:</strong> <?php echo $tanggal; ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>SubHarga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $totalBelanja = 0;
                    foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                        $ambil = $koneksi->query("SELECT * FROM produk WHERE id='$id'");
                        $pecah = $ambil->fetch_assoc();
                        if ($pecah) {
                            $harga = $pecah['harga'];
                            $subHarga = $harga * $jumlah;
                            $totalBelanja += $subHarga;
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($pecah['nama']); ?></td>
                        <td>Rp. <?php echo number_format($pecah['harga']); ?></td>
                        <td><?php echo htmlspecialchars($jumlah); ?></td>
                        <td>Rp. <?php echo number_format($subHarga); ?></td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total Belanja</th>
                        <th>Rp. <?php echo number_format($totalBelanja); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <button onclick="window.print();" class="btn btn-primary btn-print">Cetak Nota</button>
        <a href="checkout.php" class="btn btn-secondary btn-print">Kembali ke Checkout</a>
    </div>
</body>
</html>