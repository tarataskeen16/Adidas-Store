<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari database
$username = $_SESSION['pelanggan'];

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$no_hp = isset($_SESSION['no_hp']) ? $_SESSION['no_hp'] : '';
$alamat = isset($_SESSION['alamat']) ? $_SESSION['alamat'] : '';

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Update data pengguna di database
    $update = mysqli_query($koneksi, "UPDATE user SET nama='$nama', email='$email', no_hp='$hp', alamat='$alamat'");
    
    if ($update) {
        // Perbarui data di session
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        $_SESSION['no_hp'] = $no_hp;
        $_SESSION['alamat'] = $alamat;
        header("Location: profil2.php"); // Kembali ke halaman profil
    } else {
        echo "Gagal memperbarui profil!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <style>
        /* Tambahkan CSS sederhana untuk form */
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f9f9f9;
        }
        .edit-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-update {
            padding: 12px 25px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-update:hover {
            background: #555;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Profil</h2>
    <form method="POST" action="">
        <label>Nama</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($_SESSION['nama']); ?>" required>
        
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"required>
        
        <label>No. HP</label>
        <input type="text" name="no_hp" value="<?php echo htmlspecialchars($_SESSION['no_hp']); ?>" required>
        
        <label>Alamat</label>
        <input type="text" name="alamat" value="<?php echo htmlspecialchars($_SESSION['alamat']); ?>" required>
        
        <button type="submit" name="update" class="btn-update">Update Profil</button>
    </form>
</div>

</body>
</html>