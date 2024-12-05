<?php
include 'koneksi.php';
session_start();
if (isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $login = mysqli_query($koneksi,"SELECT * from user where username='$username' and password='$password' ");

if (mysqli_num_rows($login)>0) {
  $data= mysqli_fetch_assoc($login);
  if ($data ['role'] == "admin") {
    $_SESSION ['admin'] = $username;
    header("Location: admin.php");
  } elseif ($data ['role'] == "pelanggan") {
    $_SESSION['user'] = $data ['username'];
    $_SESSION['nama'] = $data ['nama'];
    $_SESSION['id_user'] = $data ['Id'];  
    $_SESSION['pelanggan'] = $data ['username']; 
    $_SESSION['email'] = $data ['email'];
    $_SESSION['no_hp'] = $data ['no_hp'];
    $_SESSION['alamat'] = $data ['alamat'];
    header("location: profil2.php");
}
} else {
  echo "username dan password salah!";
  header("Location: login.php");
}
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="login.css">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    
    <body>
    <img src="bgpink.jpeg" class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></img>
        <div class="filter">
        </div>
            <div class="container">
                <h1 class="Login">Login</h1>
                  <form action="" method="post">
                    <div>
                      <label>Username</label><br>
                      <input type="text"
                      placeholder="Enter Username" name="username" required />
                    </div>
                    <div>
                      <label type="password">Password</label><br>
                      <input type="password"
                      style="-webkit-text-security: square"
                      placeholder="Enter Password"name="password" required/>
                    </div>
                    <div class="forget">
                      <label for=""><input type="checkbox">Remember Me</label>
                    <a href="true.php">Forget Password</a>
                  </div>
                    <div class="button">
                      <button class="btn-hover color-9"type="submit" name="login">Log in</a></button>
                    </div>  
                    <div class="fluid"><br>
                      <p>don't have an account?<a href="registrasi.php"> Register</a></p>
                    </div>
                  </form>
            </div>      
    </body>
</html>