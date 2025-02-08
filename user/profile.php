<?php
session_start();
include "../koneksi.php";
$isLoggedin = false;
$avatar = "../img/default_profile.png";
$fullname = "<NULL>";

if (!isset($_SESSION['user'])) $isLoggedin = false;

if (isset($_SESSION['user'])) {
    $isLoggedin = true;
    $email = $_SESSION['user'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $userData = mysqli_fetch_assoc($query);

    if (!empty($userData['avatar'])) {
        $avatarData = base64_encode($userData['avatar']);
        $avatar = "data:image/jpeg;base64," . $avatarData;
    }
    if (!empty($userData['first_name']) && !empty($userData['last_name'])) {
        $fullname = $userData['first_name'] . ' ' . $userData['last_name'];
    }
}


if (!$isLoggedin) header("Location: /index.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style/profile_view.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="profile.php" class="navbar-brand">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo $avatar; ?>" alt="Profile Picture" class="avatar-img">
                        <span class="profile-name"><?php echo $fullname; ?></span>
                    </div>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-item" style="padding-top: 8px; padding-bottom: 8px; margin-right: 15px;">
                    <a href="/dashboard.php" class="btn btn-info btn-xs">
                        <i class="glyphicon glyphicon-arrow-left"></i> Back to Dashboard
                    </a>
                </li>
                <li class="navbar-item" style="padding-top: 8px; padding-bottom: 8px; margin-right: 15px;">
                    <a href="../index.php?action=logout" class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-log-out"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="profile-container">
                <img src="<?php echo $avatar; ?>" alt="Profile Picture">
                <h2><?php echo $fullname; ?></h2>
                <p>Email: <?php echo $userData['email']; ?></p>
                <p>Bio: <?php echo $userData['bio']; ?></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Enzo. All rights reserved.</p>
    </footer>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>