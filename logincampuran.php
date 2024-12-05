<?php
include 'koneksi.php';
session_start();
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login = mysqli_query(
        $koneksi,
        "SELECT * FROM user WHERE username='$username' AND password='$password'"
    );
    if (mysqli_num_rows($login) > 0) {
        $data = mysqli_fetch_assoc($login);
        if ($data['role'] == "admin") {
            $_SESSION['admin'] = $username;
            header("Location: admin.php");
        } elseif ($data['role'] == "pelanggan") {
            $_SESSION['user'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            header("Location: index.php");
        }
    } else {
        echo "Username dan Password salah!";
        header("Location: login.php"); // Perbaikan di sini
    }
}
?>