<?php
// SQL Authentication
$db_host = 'localhost';           // --> sever mysql
$db_user = 'root';                // --> username
$db_pass = '';                    // --> password
$db_name = 'midproject_bncc';     // --> database name

// Connect to sql
$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek Koneksi sql
if ($koneksi->connect_error) {
   die('Koneksi Gagal : ' . $koneksi->connect_error) . '';
}
?>