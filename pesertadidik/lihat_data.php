<?php 
    @session_start();

    include "../config/database.php";

    $tampil = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM query_siswa WHERE nis = '$_SESSION[username]'"));

    if (empty($_SESSION['username'])) {
        echo "<script>alert('Anda Belum Melakukan Login');document.location.href = 'index.php'</script>";
    }
?>
<title>Form Siswa</title>
<h1 align="center">Berikut Data Diri Anda : </h1>
<table align="center">
    <tr>
        <td></td>
        <td></td>
        <td>
            <img border="5" height="175" width="175" src="../foto/<?= $tampil['foto'] ?>">
        </td>
        <td></td>
    </tr>
</table>
<table align="center">
    <tr>
        <td>NIS</td>
        <td>:</td>
        <td><?= $tampil['nis']; ?></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= $tampil['nama']; ?></td>
    </tr>
    <tr>
        <td>Kelamin</td>
        <td>:</td>
        <td><?= $tampil['jk']; ?></td>
    </tr>
    <tr>
        <td>Rayon</td>
        <td>:</td>
        <td><?= $tampil['rayon']; ?></td>
    </tr>
    <tr>
        <td>Rombel</td>
        <td>:</td>
        <td><?= $tampil['rombel']; ?></td>
    </tr>
    <tr>
        <td>Tgl Lahir</td>
        <td>:</td>
        <td><?= $tampil['tgl_lahir']; ?></td>
    </tr>
</table>
<br>