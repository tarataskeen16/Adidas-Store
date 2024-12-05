<?php
session_start();
include 'koneksi.php'; // Mengimpor konfigurasi database

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];

    // Buat koneksi
    $koneksi = new mysqli($database, $username, $password, $dbname);

    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    // Menghindari SQL Injection
    $login_username = $koneksi->real_escape_string($login_username);

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($login_password === $row['password']) { // Periksa password biasa
            $_SESSION['username'] = $login_username;
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'Username not found';
    }

    $stmt->close();
    $conn->close();
}
?>