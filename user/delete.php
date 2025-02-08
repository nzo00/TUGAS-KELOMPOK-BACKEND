<?php
include "../koneksi.php";

header('Content-Type: application/json');

$id = $_GET['id'];

$result = mysqli_query($koneksi, "DELETE FROM users WHERE Id = '$id'");

if ($result) {
    if (mysqli_affected_rows($koneksi) > 0) {
        echo json_encode(["error" => false, "msg" => "Berhasil dihapus."]);
    } else {
        echo json_encode(["error" => true, "msg" => "Users tidak ditemukan."]);
    }
} else {
    echo json_encode(["error" => true, "msg" => "Gagal menghapus data."]);
}
?>
