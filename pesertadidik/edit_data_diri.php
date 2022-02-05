<?php 
    @session_start();

    include "../config/database.php";

    $tampil = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM query_siswa WHERE nis = '$_SESSION[username]'"));

    if (empty($_SESSION['username'])) {
        echo "<script>alert('Anda Belum Melakukan Login');document.location.href = 'index.php'</script>";
    }

    if ($tampil['jk'] == "L") {
        $l = 'checked="checked"';
        $p = "";
    } else {
        $p = 'checked="checked"';
        $l = "";
    }

    $date = explode("-", $tampil['tgl_lahir']);
    $thn = $date[0];
    $bln = $date[1];
    $tgl = $date[2];

    $perintah = new oop();
    $table = "tbl_siswa";
    $tanggal = @$_POST['thn'] . "-" . @$_POST['bln'] . "-" . @$_POST['tgl'];
    $where = "nis = $_GET[nis]";
    $redirect = "?menu=lihat_data";

    if (isset($_POST['batal'])) {
        header("location:hal_peserta_didik.php?menu=lihat_data");
    }

    if (isset($_POST['ubah'])) {
        $foto = @$_FILES['foto'];
        $tempat = "../foto";
        $upload = $perintah->upload($foto, $tempat);
        $field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 
        'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 
        'id_rombel' => $_POST['rombel'], 'foto' => $upload, 'tgl_lahir' => $tanggal);
        echo $perintah->ubah($table, $field, $where, $redirect);
    }
?>

<title>Form Siswa</title>
<form action="" method="post" enctype="multipart/form-data">
    <table align="center">
        <tr>
            <td></td>
            <td><img border="5" height="175" width="175" src="../foto/<?= $tampil['foto']; ?>"></td>
            <td></td>
        </tr>
    </table>
    <table align="center">
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><input type="text" name="nis" value="<?= $tampil['nis']; ?>"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?= $tampil['nama']; ?>"></td>
        </tr>
        <tr>
            <td>Kelamin</td>
            <td>:</td>
            <td>
                <input type="radio" name="jk" value="L" <?= $l; ?>>Laki-laki
                <input type="radio" name="jk" value="P" <?= $p; ?>>Perempuan
            </td>
        </tr>
        <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
                <select name="rayon">
                    <option value="<?= $tampil['id_rayon']; ?>"><?= $tampil['rayon']; ?></option>
                    <?php 
                        $E = mysqli_query($koneksi, "SELECT * FROM tbl_rayon");
                        while ($r = mysqli_fetch_array($E)) { 
                    ?>
                    <option value="<?= $r[0]; ?>"><?= $r[1]; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rombel</td>
            <td>:</td>
            <td>
                <select name="rombel">
                    <option value="<?= $tampil['id_rombel']; ?>"><?= $tampil['rombel']; ?></option>
                    <?php 
                        $E = mysqli_query($koneksi, "SELECT * FROM tbl_rombel");
                        while ($r = mysqli_fetch_array($E)) { 
                    ?>
                    <option value="<?= $r[0]; ?>"><?= $r[1]; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Foto</td>
            <td>:</td>
            <td colspan="2"><input type="file" name="foto"></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
                <select name="tgl">
                    <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                    <option value="">-------</option>
                    <?php 
                        for ($tgl = 1; $tgl <= 31; $tgl++) { 
                            if ($tgl <= 9) {
                    ?>
                    <option value="<?= "0" . $tgl; ?>"><?= "0" . $tgl; ?></option>
                    <?php 
                            } else {
                    ?>
                    <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                    <?php 
                            }
                        }
                    ?>
                </select>
                <select name="bln">
                    <option value="<?= $bln; ?>"><?= $bln; ?></option>
                    <option value="">-------</option>
                    <?php 
                        for ($bln = 1; $bln <= 12; $bln++) { 
                            if ($bln <= 9) {
                    ?>
                    <option value="<?= "0" . $bln; ?>"><?= "0" . $bln; ?></option>
                    <?php 
                            } else {
                    ?>
                    <option value="<?= $bln; ?>"><?= $bln; ?></option>
                    <?php 
                            }
                        }
                    ?>
                </select>
                <select name="thn">
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <option value="">-------</option>
                    <?php 
                        for ($thn = 1990; $thn <= 2012; $thn++) {
                    ?>
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" name="batal" value="Batal">
                <input type="submit" name="ubah" value="Ubah">
            </td>
        </tr>
    </table>
    <br>
</form>