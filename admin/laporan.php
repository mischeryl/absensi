<?php 
    date_default_timezone_set('Asia/Bangkok');
?>

<?php 
    include '../config/database.php';

    $perintah = new oop();

    if (!empty(@$_GET['rombel'])) {
        $isinya = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_rombel WHERE id_rombel = @$_GET[rombel]"));
    }
?>
<title>Laporan Absensi</title>
<br>
<center>
    <font size="+3">Form Laporan Absensi</font>
</center>
<hr>
<form action="" method="post">
    <table align="center">
        <tr>
            <td>Pilih Rombel</td>
            <td>:</td>
            <td>
                <select name="rombel"> 
                    <?php 
                        $a = $perintah->tampil("tbl_rombel");
                        foreach ($a as $r) {
                    ?>
                    <option value="<?= $r['0']; ?>"><?= $r['1']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="submit" name="cetak" value="Cetak"></td>
        </tr>
    </table>
    <br>
    <?php 
        if (isset($_POST['cetak'])) {
            $rombel = @$_POST['rombel'];
            if ($rombel == "") {
                echo "<script>alert('Pilih rombel terlebih dahulu!'); document.location.href='hal_admin.php?menu=laporan'</script>";
            } else {
                echo "<script>document.location.href = 'laporan_today.php?menu=laporan&rombel=$rombel'</script>";
            }
        }
    ?>
</form>
<br>