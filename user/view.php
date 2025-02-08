<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE Id = ?";
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $fullname = $first_name . ' ' . $last_name;  // Combine first_name and last_name
            $email = $row['email'];
            $bio = $row['bio'];
            $avatar = $row['avatar'];  // Get avatar (BLOB data)
        } else {
            echo "<script>alert('Data not found'); window.location.href='index.php';</script>";
            exit;
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style/user_view.css">
</head>
<body>

    <div class="container">
        <div class="profile-card">

            <!-- Name Heading -->
            <h3 class="text-center mb-4"><?php echo $fullname; ?></h3>

            <!-- Avatar Section -->
            <div class="avatar-section">
                <?php
                if ($avatar) echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" class="avatar-img" />';
                else echo '<img src="../img/default_profile.png" class="avatar-img" />';
                ?>
            </div>

            <!-- User Data -->
            <div class="user-data">
                <div><strong>First Name:</strong> <?php echo $first_name; ?></div>
                <div><strong>Last Name:</strong> <?php echo $last_name; ?></div>
            </div>

            <div class="user-data">
                <div><strong>Email:</strong> <?php echo $email; ?></div>
                <div><strong>Bio:</strong> <?php echo $bio; ?></div>
            </div>

            <a href="../index.php" class="btn btn-outline-primary btn-back">Back to Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
