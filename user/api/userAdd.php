<?php
include "../../koneksi.php";

header('Content-Type: application/json');

$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$bio = $_POST['bio'] ?? '';

// Pastikan email menggunakan domain yang diizinkan
if (!preg_match("/@(gmail\\.com|binus\\.ac\\.id)$/", $email)) {
    echo json_encode(["error" => true, "msg" => "Email harus menggunakan domain @gmail.com atau @binus.ac.id"]);
    exit;
}

// Cek jika semua data wajib sudah terisi
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    echo json_encode(["error" => true, "msg" => "Masih ada data yang kosong."]);
    exit;
}

// Cek apakah email sudah terdaftar
$sql_check = "SELECT id FROM users WHERE email = ?";
$stmt_check = $koneksi->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(["error" => true, "msg" => "Email sudah terdaftar."]);
    $stmt_check->close();
    $koneksi->close();
    exit;
}

$stmt_check->close();

$avatarData = NULL; 
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $avatarType = $_FILES['avatar']['type'];
    if (!in_array($avatarType, ['image/jpeg', 'image/png', 'image/gif'])) {
        echo json_encode(["error" => true, "msg" => "Invalid file type. Only JPEG, PNG, or GIF images are allowed."]);
        exit;
    }

    $avatarData = file_get_contents($_FILES['avatar']['tmp_name']);
}

$hashed_password = md5($password);

$sql = "INSERT INTO users (id, first_name, last_name, email, password, bio, avatar) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("sssssb", $first_name, $last_name, $email, $hashed_password, $bio, $avatarData);

if ($stmt->execute()) {
    echo json_encode(["error" => false, "msg" => "Data berhasil disimpan. "]);
} else {
    echo json_encode(["error" => true, "msg" => "Gagal menyimpan data: " . $stmt->error]);
}

$stmt->close();
$koneksi->close();
?>
