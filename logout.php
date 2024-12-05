<?php
session_start();
session_destroy();//manghancurkan sesi
header('Location: login.php');//kembali ke halaman login
exit();
?>