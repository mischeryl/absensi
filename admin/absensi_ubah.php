<?php 
    date_default_timezone_set('Asia/Bangkok');
?>

<?php 
    include "../config/database.php";

    $perintah = new oop();

    $id = @$_GET['id'];
    $where = "nis =" . @$_GET['nis'];
    $query = "query_absen";
    $table = "tbl_rombel";
?>

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
        </tr>
        <tr>
            <td>Tanggal Absen</td>
            <td>:</td>
            <td>
                <select name="tgl">
                    <option value=""></option>
                    <?php 
                        for ($tgl = 1; $tgl <= 31; $tgl++) { 
                            if ($tgl <= 9) {
                                ?>
                                <option value="<?= "0" . $tgl; ?>"><?= "0" . $tgl; ?></option>
                            <?php } else { ?>
                                <option value="<?= $tgl; ?>"><?= $tgl; ?></option>
                            <?php } 
                        } ?>
                </select>
                <select name="bln">
                    <option value=""></option>
                    <?php 
                        for ($bln = 1; $bln <= 12 ; $bln++) { 
                            if ($bln <= 9) {
                                ?>
                                <option value="<?= "0" . $bln; ?>"><?= "0" . $bln; ?></option>
                            <?php } else { ?>
                                <option value="<?= $bln; ?>"><?= $bln; ?></option>
                            <?php }
                        } ?>
                </select>
                <select name="thn">
                    <option value=""></option>
                    <?php 
                        for ($thn = 2011; $thn <= 2030; $thn ++) { 
                    ?>
                    <option value="<?= $thn; ?>"><?= $thn; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <td><input type="submit" name="cetak" value="Cetak"></td>
    </table>
    <hr>
    <?php 
        if (isset($_POST['cetak'])) {
            $rombel = $_POST['rombel'];
            $thn = $_POST['thn'];
            $bln = $_POST['bln'];
            $tgl = $_POST['tgl'];
    ?>
    <script>document.location.href='?menu=ubahabsen&rombel=<?= $rombel; ?>&thn=<?= $thn;?>&bln=<?= $bln;?>&tgl=<?= $tgl;?>'</script>
    <?php
        }
        if (!empty(@$_GET['rombel'])) {
    ?>
    <table border="1" cellspacing="0" align="center">
        <tr align="center">
            <td rowspan="2">No</td>
            <td rowspan="2">NIS</td>
            <td rowspan="2">Nama</td>
            <td rowspan="2">Rombel</td>
            <td colspan="4" align="center">Keterangan</td>
        </tr>
        <tr>
            <td>Hadir</td>
            <td>Sakit</td>
            <td>Izin</td>
            <td>Alpa</td>
        </tr>
        <?php 
            $rombel = @$_GET['rombel'];
            $thn = @$_GET['thn'];
            $bln = @$_GET['bln'];
            $tgl = @$_GET['tgl'];
            $a = $perintah->tampil("query_absen WHERE id_rombel = '$rombel' AND tgl_absen = '$thn-$bln-$tgl'");
            $no = 0;
            if ($a == "") {
                echo "<tr><td align='center' colspan='8'>NO RECORD</td></tr>";
            } else {
                foreach ($a as $r) {
                    $no++;

                    if ($r['hadir'] == 1) {
                        $hadir = "checked";
                        $sakit = "";
                        $izin = "";
                        $alpa = "";
                    }
                    if ($r['sakit'] == 1) {
                        $hadir = "";
                        $sakit = "checked";
                        $izin = "";
                        $alpa = "";
                    }
                    if ($r['ijin'] == 1) {
                        $hadir = "";
                        $sakit = "";
                        $izin = "checked";
                        $alpa = "";
                    }
                    if ($r['alpa'] == 1) {
                        $hadir = "";
                        $sakit = "";
                        $izin = "";
                        $alpa = "checked";
                    }
        ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $r['nis']; ?></td>
            <td><?= $r['nama']; ?></td>
            <td><?= $r['rombel']; ?></td>
            <td><input type="radio" name="keterangan<?= $r['nis']; ?>" value="hadir" <?= $hadir; ?>></td>
            <td><input type="radio" name="keterangan<?= $r['nis']; ?>" value="sakit" <?= $sakit; ?>></td>
            <td><input type="radio" name="keterangan<?= $r['nis']; ?>" value="ijin" <?= $izin; ?>></td>
            <td><input type="radio" name="keterangan<?= $r['nis']; ?>" value="alpa" <?= $alpa; ?>></td>
        </tr>
        <?php 
            $tgl = date('Y-m-d');
            $table = "tbl_absen";
            $redirect = '?menu=ubahabsen';
            $where = "nis = $r[nis]";

            if (@$_POST['keterangan' . $r['nis']] == 'hadir') {
                $field = array('nis' => $r['nis'], 'hadir' => '1', 'sakit' => '0', 'ijin' => '0', 'alpa' => '0', 'tgl_absen' => $tgl);
            } elseif (@$_POST['keterangan' . $r['nis']] == 'sakit') {
                $field = array('nis' => $r['nis'], 'hadir' => '0', 'sakit' => '1', 'ijin' => '0', 'alpa' => '0', 'tgl_absen' => $tgl);
            } elseif (@$_POST['keterangan' . $r['nis']] == 'ijin') {
                $field = array('nis' => $r['nis'], 'hadir' => '0', 'sakit' => '0', 'ijin' => '1', 'alpa' => '0', 'tgl_absen' => $tgl);
            } else {
                $field = array('nis' => $r['nis'], 'hadir' => '0', 'sakit' => '0', 'ijin' => '0', 'alpa' => '1', 'tgl_absen' => $tgl);
            }
                if (isset($_REQUEST['ubah'])) {
                    $perintah->ubah($table, $field, $where, $redirect);
                }
            }
        ?>
        <tr>
            <td colspan="10" align="center"><input type="submit" name="ubah" value="Ubah"></td>
        </tr>
    </table>
    <?php } } ?>
</form>
<br>