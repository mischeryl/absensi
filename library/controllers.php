<?php

class oop {
    static $connection;

    static function conn() {
        self::$connection = mysqli_connect("localhost", "root", "") or die("Kesalahan Koneksi... !!");
        mysqli_select_db(self::$connection, "db_absensi") or die("Database error!");
    }

    function ubah($table, array $field, $where, $redirect) {
        self::conn();
        $sql = "UPDATE {$table} SET ";
        foreach ($field as $key => $value) {
            $sql .= "{$key} = '{$value}', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= "WHERE {$where}";
        $jalan = mysqli_query(self::$connection, $sql);
        if ($jalan) {
            echo "<script>alert('Berhasil'); document.location.href='{$redirect}'</script>";
        } else {
            echo mysqli_error();
        }  
    }

    function simpan($table, array $field, $redirect) {
        self::conn();
        $sql = "INSERT INTO {$table} SET ";
        foreach ($field as $key => $value) {
            $sql .= "{$key} = '{$value}', ";
        }
        $sql = rtrim($sql, ', ');
        $jalan = mysqli_query(self::$connection, $sql);
        if ($jalan) {
            echo "<script>alert('Berhasil'); document.location.href='{$redirect}'</script>";
        } else {
            echo mysqli_error();
        }
    }

    function tampil($table) {
        self::conn();
        $sql = "SELECT * FROM {$table}";
        $tampil = mysqli_query(self::$connection, $sql);
        if (!empty(mysqli_fetch_array($tampil))) {
            $sql = "SELECT * FROM {$table}";
            $tampil = mysqli_query(self::$connection, $sql);
            while ($data = mysqli_fetch_array($tampil)) 
            $isi[] = $data;
            return $isi;
        }
    }

    function hapus($table, $where, $redirect) {
        self::conn();
        $sql = "DELETE FROM {$table} WHERE $where";
        $jalan = mysqli_query(self::$connection, $sql);
        if ($jalan) {
            echo "<script>alert('Berhasil'); document.location.href='{$redirect}'</script>";
        } else {
            echo mysqli_error();
        }
    }

    function edit($table, $where) {
        self::conn();
        $sql = "SELECT * FROM $table WHERE $where";
        $jalan = mysqli_query(self::$connection, $sql);
        $tampil = mysqli_fetch_array($jalan);
        return $tampil;
    }

    function upload($foto, $tempat) {
        $alamat = $foto['tmp_name'];
        $namafile = $foto['name'];
        move_uploaded_file($alamat, "$tempat/$namafile");
        return $namafile;
    }

    function login($table, $username, $password, $nama_form) {
        self::conn();
        @session_start();
        $sql = "SELECT * FROM $table WHERE username = '$username' && password = '$password'";
        $jalan = mysqli_query(self::$connection, $sql);
        $tampil = mysqli_fetch_array($jalan);
        $cek = mysqli_num_rows($jalan);
        if ($cek > 0) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Login Berhasil'); document.location.href='$nama_form'</script>";
        } else {
            echo "<script>alert('Login gagal cek username dan password!!');</script>";
        }
    }
}

?>