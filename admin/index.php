<?php
session_start();

include '../config/database.php';
include '../library/controllers.php';

$perintah = new oop();


$table = "tbl_user";
$username = @$_POST['user'];
$password = @$_POST['pass'];
$nama_form = "hal_admin.php?menu=home";

if (isset($_POST['login'])) {
    $perintah->login($table, $username, $password, $nama_form);
}

if (isset($_POST['batal'])) {
    header("location:../");
}

?>

<title>Login</title>
<form action="" method="post">
  <table align="center">
    <tr>
      <td>Username</td>
      <td>:</td>
      <td><input type="text" name="user"></td>
    </tr>

    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input type="password" name="pass"></td>
    </tr>

    <tr>
      <td></td>
      <td></td>
      <td><input type="submit" name="login" value="LOGIN">
        <input type="submit" name="batal" value="BATAL"></td>
    </tr>
  </table>
</form>