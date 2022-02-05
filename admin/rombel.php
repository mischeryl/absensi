<?php 
    include "../config/database.php";

    $perintah = new oop();

    $table = "tbl_rombel";
    $where = "id_rombel = " . @$_GET['id'];
    $redirect = "?menu=rombel";
    $field = array('rombel' => @$_POST['rombel']);

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
            <td>Rombel</td>
            <td>:</td>
            <td>
                <?php
                    if (@$_GET['id'] == "") {
                ?> 
                    <input type="text" name="rombel" required placeholder="Rombel"> 
                <?php
                    } else {
                    $edit = $perintah->edit($table, $where);
                ?> 
                    <input type="text" name="rombel" value="<?= $edit['rombel']; ?>" required> 
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

<link rel="stylesheet" href="../css/button.css">
<table align="center" border="1" class="text-center" cellspacing="0" cellpadding="2">
    <tr>
        <td>No</td>
        <td>Rombel</td>
        <td colspan="2">Aksi</td>
    </tr>
    <?php 
        $a = $perintah->tampil($table);
        $no = 0;
        if ($a == "") {
            echo "<tr><td align='center' colspan='10'>NO RECORD</td></tr>";
        } else {
            foreach ($a as $r) {
                $no++;
    ?>
    <tr class="h35">
        <td><?= $no; ?></td>
        <td><?= $r['rombel']; ?></td>
        <td>
            <a href="?menu=rombel&edit&id=<?= $r['id_rombel']; ?>" class="b bEdit">Edit</a>
        </td>
        <td>
            <a href="?menu=rombel&hapus&id=<?= $r['id_rombel']; ?>" onclick="return confirm('Hapus Data?')" class="b bHapus">Hapus</a>
        </td>
    </tr>
    <?php } } ?>
</table>
<br>