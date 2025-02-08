<?php
include "../../koneksi.php";

$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
$first_name = isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
$bio = isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
            alert('Invalid email format');
            document.location.href='../edit.php?id=$id';
        </script>";
    exit;
}

if (!empty($first_name) && !empty($last_name) && !empty($email)) {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar = $_FILES['avatar']['tmp_name'];
        $avatarData = file_get_contents($avatar);  // Get the binary data from the image file
        $avatarEncoded = $avatarData;
    } else {
        $avatarEncoded = NULL;
    }

    if (!empty($password)) {
        $hashed_password = md5($password);
        if ($avatarEncoded) {
            $sql = "UPDATE users SET first_name = ?, last_name = ?, password = ?, email = ?, bio = ?, avatar = ? WHERE id = ?";
            if ($stmt = $koneksi->prepare($sql)) {
                $stmt->bind_param('ssssssi', $first_name, $last_name, $hashed_password, $email, $bio, $avatarEncoded, $id);
            } else {
                echo "<script>
                        alert('Failed to prepare the SQL statement');
                        document.location.href='../edit.php?id=$id';
                    </script>";
                exit;
            }
        } else {
            $sql = "UPDATE users SET first_name = ?, last_name = ?, password = ?, email = ?, bio = ? WHERE id = ?";
            if ($stmt = $koneksi->prepare($sql)) {
                $stmt->bind_param('sssssi', $first_name, $last_name, $hashed_password, $email, $bio, $id);
            } else {
                echo "<script>
                        alert('Failed to prepare the SQL statement');
                        document.location.href='../edit.php?id=$id';
                    </script>";
                exit;
            }
        }
    } else {
        // Update without changing the password
        if ($avatarEncoded) {
            $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, bio = ?, avatar = ? WHERE id = ?";
            if ($stmt = $koneksi->prepare($sql)) {
                $stmt->bind_param('sssssi', $first_name, $last_name, $email, $bio, $avatarEncoded, $id);
            } else {
                echo "<script>
                        alert('Failed to prepare the SQL statement');
                        document.location.href='../edit.php?id=$id';
                    </script>";
                exit;
            }
        } else {
            $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, bio = ? WHERE id = ?";
            if ($stmt = $koneksi->prepare($sql)) {
                $stmt->bind_param('ssssi', $first_name, $last_name, $email, $bio, $id);
            } else {
                echo "<script>
                        alert('Failed to prepare the SQL statement');
                        document.location.href='../edit.php?id=$id';
                    </script>";
                exit;
            }
        }
    }

    // Execute the query
    if ($stmt->execute()) {
        echo "
        <script language='javascript'>
            alert('Berhasil Disimpan');
            document.location.href='../../index.php';
        </script>";
    } else {
        echo "
        <script language='javascript'>
            alert('Gagal menyimpan data');
            document.location.href='../edit.php?id=$id';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Masih ada data yang kosong');
        document.location.href='data_edit.php?id=$id';
    </script>";
}
?>
