<link rel="stylesheet" href="../css/button.css">


<?php 
    include "../config/database.php";

    $perintah = new oop();

        $table = "tbl_siswa";
        $query = "query_siswa";
        $where = "nis = ". @$_GET['id'];
        $redirect = "?menu=siswa";
        $tanggal = @$_POST['thn'] . "-" . @$_POST['bln'] . "-" . @$_POST['tgl'];
        $tempat = "../foto";

    if (isset($_POST['simpan'])) {
        $foto = $_FILES['foto'];
        $upload = $perintah->upload($foto, $tempat);
        $field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'foto' => $upload, 'tgl_lahir' => $tanggal);
        $perintah->simpan($table, $field, $redirect);
    }

    if (isset($_GET['hapus'])) {
        $perintah->hapus($table, $where, $redirect);
    }

    if (isset($_GET['edit'])) {
        $edit = $perintah->edit($query, $where);
        if ($edit['jk'] == "L") {
            $l = 'checked="checked"';
            $p = "";
        } else {
            $p = 'checked="checked"';
            $l = "";
        }
        $date = explode("-", $edit['tgl_lahir']);
        $thn = $date[0];
        $bln = $date[1];
        $tgl = $date[2];
    }

    if (isset($_POST['ubah'])) {
        $foto = $_FILES['foto'];
        $upload = $perintah->upload($foto, $tempat);
        if (empty($_FILES['foto']['name'])) {
            $field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'tgl_lahir' => $tanggal);
            $perintah->ubah($table, $field, $where, $redirect);
        } else {
            $field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'foto' => $upload, 'tgl_lahir' => $tanggal);
            $perintah->ubah($table, $field, $where, $redirect);
        }
    }
?>

<?php 
    if (@$_GET['id'] == "") {
?>

<form action="" method="post" enctype="multipart/form-data">
    <table align="center">
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><input type="text" name="nis"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                <input type="radio" name="jk" required value="L"> Laki-laki
                <input type="radio" name="jk" required value="P"> Perempuan
            </td>
        </tr>
        <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
                <select name="rayon" required>
                    <?php 
                        $a = $perintah->tampil("tbl_rayon");
                        foreach ($a as $r) {
                    ?>
                    <option value="<?= $r['0']; ?>"><?= $r['1']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rombel</td>
            <td>:</td>
            <td>
                <select name="rombel" required>
                    <?php 
                        $a = $perintah->tampil("tbl_rombel");
                        foreach ($a as $r) {
                    ?>
                    <option value="<?= $r['0'] ?>"><?= $r['1'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Foto</td>
            <td>:</td>
            <td><input type="file" name="foto"></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
                <select name="tgl" required>
                    <?php 
                        for ($tgl = 1; $tgl <= 30; $tgl++) { 
                            if ($tgl <= 9) {
                                ?>
                                <option value="<?= "0" . $tgl; ?>"><?= "0" . $tgl; ?></option>
                            <?php } else { ?>
                                <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                            <?php } 
                        } 
                    ?>
                    <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                </select>
                <select name="bln" required>
                    <?php 
                        for ($bln = 1; $bln <= 12 ; $bln++) { 
                            if ($bln <= 9) {
                                ?>
                                <option value="<?= "0" . $bln; ?>"><?= "0" . $bln; ?></option>
                            <?php } else { ?>
                                <option value="<?= $bln; ?>"><?= $bln; ?></option>
                            <?php }
                        } 
                    ?>
                </select>
                <select name="thn" required>
                    <?php 
                        for ($thn = 1989; $thn <= 2015; $thn ++) { 
                    ?>
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="Simpan" class="b bSimpan">
            </td>
        </tr>
    </table>
</form>

<?php } else { ?>

<form action="" method="post" enctype="multipart/form-data">
    <table align="center">
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><input type="text" name="nis" value="<?= $edit['nis']; ?>" required></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?= $edit['nama'] ?>"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                <input type="radio" name="jk" required <?= $l; ?> value="L"> Laki-laki
                <input type="radio" name="jk" required <?= $p; ?> value="P"> Perempuan
            </td>
        </tr>
        <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
                <select name="rayon" required>
                    <option value="<?= $edit['id_rayon'] ?>"><?= $edit['rayon'] ?></option>
                    <option value="" disabled>-----------</option>
                    <?php 
                        $a = $perintah->tampil("tbl_rayon");
                        foreach ($a as $r) {
                    ?>
                    <option value="<?= $r['0']; ?>"><?= $r['1']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rombel</td>
            <td>:</td>
            <td>
                <select name="rombel" required>
                    <option value="<?= $edit['id_rombel'] ?>"><?= $edit['rombel'] ?></option>
                    <option value="" disabled>-----------</option>
                    <?php 
                        $a = $perintah->tampil("tbl_rombel");
                        foreach ($a as $r) {
                    ?>
                    <option value="<?= $r['0'] ?>"><?= $r['1'] ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Foto</td>
            <td>:</td>
            <td><input type="file" name="foto"></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
                <select name="tgl" required>
                    <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                    <option value="" disabled>---</option>
                    <?php 
                        for ($tgl = 1; $tgl <= 31; $tgl++) { 
                            if ($tgl <= 9) {
                                ?>
                                <option value="<?= "0" . $tgl; ?>"><?= "0" . $tgl; ?></option>
                            <?php } else { ?>
                                <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                            <?php } 
                        } 
                    ?>
                    <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                </select>
                <select name="bln" required>
                    <option value="<?= $bln; ?>"><?= $bln; ?></option>
                    <option value="" disabled>---</option>
                    <?php 
                        for ($bln = 1; $bln <= 12 ; $bln++) { 
                            if ($bln <= 9) {
                                ?>
                                <option value="<?= "0" . $bln; ?>"><?= "0" . $bln; ?></option>
                            <?php } else { ?>
                                <option value="<?= $bln; ?>"><?= $bln; ?></option>
                            <?php }
                        } 
                    ?>
                </select>
                <select name="thn" required>
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <option value="" disabled>-------</option>
                    <?php 
                        for ($thn = 1989; $thn <= 2015; $thn ++) { 
                    ?>
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" name="ubah" value="Ubah" class="b bEdit">
            </td>
        </tr>
    </table>
</form>

<?php } ?>
<link rel="stylesheet" href="../css/style.css">

<table align="center" border="1" cellpadding="2" cellspacing="0" class="text-center">
    <tr>
        <td>No</td>
        <td>Nis</td>
        <td>Nama</td>
        <td>JK</td>
        <td>Rayon</td>
        <td>Rombel</td>
        <td>Foto</td>
        <td>Tanggal Lahir</td>
        <td colspan="2">Aksi</td>
    </tr>
    <?php 
        $a = $perintah->tampil("query_siswa");
        $no = 0;
        if ($a == "") {
            echo "<tr><td align='center' colspan='10'>NO RECORD</td></tr>";
        } else {
            foreach ($a as $r) {
                $no++;
    ?>
    <tr>
        <td><?= $no; ?></td>
        <td><?= $r['nis']; ?></td>
        <td><?= $r['nama']; ?></td>
        <td><?= $r['jk']; ?></td>
        <td><?= $r['rayon']; ?></td>
        <td><?= $r['rombel']; ?></td>
        <td><img src="../foto/<?= $r['foto']; ?>" width="50" height="50"></td>
        <td><?= $r['tgl_lahir']; ?></td>
        <td>
            <a href="?menu=siswa&edit&id=<?= $r['nis']; ?>" class="b bEdit">Edit</a>
        </td>
        <td>
            <a href="?menu=siswa&hapus&id=<?= $r['nis']; ?>" onclick="return confirm('Hapus record?')" class="b bHapus">Hapus</a>
        </td>
    </tr>
    <?php } } ?>
</table>
<br>