<?php

$koneksi = mysqli_connect("localhost", "root", "") or die("Kesalahan Koneksi... !!");
mysqli_select_db($koneksi, "db_absensi") or die("Database error!");


?>