<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];    
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $alamat =$_POST['alamat'];
    if ($nama && $email && $username && $password) {
    $simpan = mysqli_query($koneksi,"INSERT INTO user(nama,email,username,password,no_hp,alamat,role)
     VALUES('$nama','$email','$username','$password','$no_hp','$alamat','pelanggan')" );

     if ($simpan) {
        header('Location: login.php');
     }
    }
  }

?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="registrasi.css">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
    </head>
    
    <body>
    <img src="adidasbg.jpeg" class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></img>
          <div class="filter">
        </div>
            <div class="container">
                <h1>Register</h1>
                  <form method="POST" enctype="multipart/form-data">
                    <div>
                    <label>nama</label><br>
                    <input type="text" name="nama"
                    placeholder="Enter nama" required /><br>
                    </div>
                    <div>
                    <label>email</label><br>
                    <input type="email" name="email"
                    placeholder="Enter email" required /><br>
                    </div>
                    <div>
                    <label><u></u>username</label><br>
                    <input type="text" name="username"
                    placeholder="Enter username" required /><br>
                    </div>
                    <div>
                    <label type="password">password</label><br>
                    <input type="password"
                    style="-webkit-text-security: square"
                    placeholder="Enter password"  name="password" required/><br>
                    </div>
                    <div>
                    <label>no hp</label><br>
                    <input type="number" name="no_hp"
                    placeholder="Enter no hp" required /><br>
                    </div>
                    <div>
                    <label>alamat</label><br>
                    <input type="text" name="alamat"
                    placeholder="Enter alamat" required /><br>
                    </div>
                    <div class="button">
                    <button class="btn-hover color-9"type="submit" name="simpan" >
                        Register        
                </button>
                    </div>
                </form>
            </div>      
    </body>
</html>