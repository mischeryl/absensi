<?php 
    include "../config/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN ABSEN</title>
</head>
<body>
    <style>
        .utama {
            margin: 0 auto;
            border: thin solid #000;
            width: 700px;
        }
        .print {
            margin: 0 auto;
            width: 700px;
        }
        a {
            text-decoration: none;
        }
    </style>
    <div class="print">
        <a href="#" onclick="document.getElementById('print').style.display='none';window.print();">
            <img src="../images/print-icon.png" id="print" width="25" height="25" border="0">
        </a>
    </div>
    <div class="utama">
        <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top: 10px;">
            <tr>
                <td width="7%" rowspan="3" align="center" valign="top">
                    <img src="../images/logo.png" width="55" height="55">
                </td>
                <td width="93%" valign="top">
                    <strong>&nbsp;LAPORAN KEHADIRAN</strong>
                </td>
            </tr>
            <tr>
                <td valign="top">&nbsp;SMK Wikrama Kota Bogor</td>
            </tr>
            <tr>
                <td valign="top">&nbsp;Ilmu yang Amaliah, Amal yang Ilmiah, Akhlakul Karimah</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
        </table>
        <table cellspacing="1" align="center" border="1">
            <tr align="center">
                <td rowspan="2">No</td>        
                <td rowspan="2" width="100">NIS</td>        
                <td rowspan="2" width="150">Nama</td>        
                <td rowspan="2" width="100">Rombel</td>        
                <td colspan="4">Keterangan</td>        
                <td rowspan="2" width="50">Bulan</td>        
                <td rowspan="2">Lihat</td>
            </tr>
            <tr align="center">
                <td width="25">H</td>        
                <td width="25">S</td>        
                <td width="25">I</td>                    
                <td width="25">A</td>                    
            </tr>
            <?php 
                $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM query_absen"));
                $bulan_sekarang_db = $data['tgl_absen'];
                $ambil_bulan = substr($bulan_sekarang_db, 5, 2);
                $bulan_sekarang = date('Y-m-d');
                $bulan = substr($bulan_sekarang, 5, 2);

                if ($bulan == $ambil_bulan) {
                    $nis = @$_GET['nis'];
                    $sql = mysqli_query($koneksi, "SELECT SUM(hadir) AS hadir, SUM(sakit) AS sakit, SUM(ijin) AS ijin, SUM(alpa) AS alpa, nis, nama, rombel, tgl_absen, id_rombel FROM query_absen WHERE nis = '$nis' GROUP BY nis");
                    $no = 0;
                    while ($r = mysqli_fetch_array($sql)) {
                        $no++;
            ?>
            <tr align="center">
                <td><?= $no; ?></td>
                <td><?= $r['nis']; ?></td>
                <td><?= $r['nama']; ?></td>
                <td><?= $r['rombel']; ?></td>
                <td><?= $r['hadir']; ?></td>
                <td><?= $r['sakit']; ?></td>
                <td><?= $r['ijin']; ?></td>
                <td><?= $r['alpa']; ?></td>
                <td><?= date('M') ?></td>
                <td>
                <a href="laporan_rombel_detail.php?rombel=<?php echo $r['id_rombel'] ?>&nis=<?php echo $r['nis'] ?>&tgl=<?php echo $r['tgl_absen'] ?>">
          Detail</a>
                </td>
            </tr>
            <?php }} ?>
        </table>
        <br>
    </div>
</body>
<center><p>&copy; <?= date('Y'); ?>SMK WIKRAMA BOGOR</p></center>
</html>