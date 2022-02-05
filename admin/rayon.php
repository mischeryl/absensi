<?php 
    include "../config/database.php";

    $perintah = new oop();

    $table = "tbl_rayon";
    $where = "id_rayon = " . @$_GET['id'];
    $redirect = "?menu=rayon";
    $field = array('rayon' => @$_POST['rayon']);    

    if (isset($_POST['simpan'])) {
        $perintah->simpan($table, $field, $redirect);
    }

    if (isset($_GET['hapus'])) {
        $perintah->hapus($table, $where, $redirect);
    }

    if (isset($_POST['edit'])) {
        $edit = $perintah->edit($table, $where);
    }

    if (isset($_POST['ubah'])) {
        $perintah->ubah($table, $field, $where, $redirect);
    }
?>

<link rel="stylesheet" href="../css/button.css">
<form method="post">
    <table align="center">
        <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
                <?php
                    if (@$_GET['id'] == "") {
                ?>
                    <input type="text" name="rayon" required placeholder="Rayon"> 
                <?php
                    } else {
                    $edit = $perintah->edit($table, $where);
                ?> 
                    <input type="text" name="rayon" value="<?= $edit['rayon'] ?>" required> 
                <?php
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <?php if (@$_GET['id'] == "") { ?>
                    <input type="submit" name="simpan" value="Simpan" class="b bSimpan">
                <?php } else { ?>
                    <input type="submit" name="ubah" value="Ubah">
                <?php } ?>
            </td>
        </tr>
    </table>
</form>

<br>

<table align="center" border="1" class="text-center" cellspacing="0" cellpadding="2">
    <tr>
        <td>No</td>
        <td>Rayon</td>
        <td colspan="2">Aksi</td>
    </tr>
    <?php 
        $a = $perintah->tampil($table);
        $no = 0;
        if ($a == "") {
            echo "<tr><td align='center' colspan='4'>NO RECORD</td></tr>";
        } else {
            foreach ($a as $r) {
                $no++;
    ?>
    <tr class="h35">
        <td><?= $no; ?></td>
        <td><?= $r['rayon']; ?></td>
        <td>
            <a href="?menu=rayon&edit&id=<?= $r['id_rayon']; ?>" class="b bEdit">Edit</a>
        </td>
        <td>
            <a href="?menu=rayon&hapus&id=<?= $r['id_rayon']; ?>" onclick="return confirm('Hapus Data?')" class="b bHapus">Hapus</a>
        </td>
    </tr>
    <?php } } ?>
</table>
<br>