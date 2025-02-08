<?php
session_start();
include "koneksi.php";

// Default values
$isAdmin = false;
$isLoggedin = false;
$avatar = "img/default_profile.png";
$fullname = "";

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $isLoggedin = true;
    if ($_SESSION['user'] == "adminBNCC@gmail.com") {
        $isAdmin = true;
    }

    // Load user data
    $email = $_SESSION['user'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $userData = mysqli_fetch_assoc($query);

    if ($userData) {
        $avatar = !empty($userData['avatar']) ? "data:image/jpeg;base64," . base64_encode($userData['avatar']) : $avatar;
        $fullname = !empty($userData['first_name']) && !empty($userData['last_name']) ? $userData['first_name'] . ' ' . $userData['last_name'] : $fullname;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tugas Backend - Dashboard</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style/dashboard_view.css">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="user/profile.php" class="navbar-brand">
                    <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Profile Picture" class="avatar-img">
                    <span class="profile-name"><?php echo htmlspecialchars($fullname); ?></span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($isLoggedin): ?>
                        <li><a href="user/profile.php" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-user"></i>
                                My Profile</a></li>
                    <?php else: ?>
                        <li><a href="user/login.php" class="btn btn-success btn-xs"><i
                                    class="glyphicon glyphicon-log-in"></i> Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
    <div class="col-md-12">
        <br><br>
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Bio</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $result = mysqli_query($koneksi, "SELECT * FROM users ORDER BY Id ASC");
                            while ($row = mysqli_fetch_assoc($result)) {
                                $no++;
                                $avatar = !empty($row['avatar']) ? "data:image/jpeg;base64," . base64_encode($row['avatar']) : "img/default_profile.png";
                            ?>
                                <tr>
                                    <td><?php echo $row['Id']; ?></td>
                                    <td><img src="<?php echo htmlspecialchars($avatar); ?>" width="50" height="50"></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['bio']); ?></td>
                                    <td>
                                        <?php
                                        if ($isAdmin) {
                                            echo '
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="user/edit.php?id=' . $row["Id"] . '"><i class="glyphicon glyphicon-check"></i> Edit</a></li>
                                                    <li><a href="user/view.php?id=' . $row["Id"] . '"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
                                                    <li><a href="javascript:;" data-id="' . $row["Id"] . '" data-toggle="modal" data-target="#modal-konfirmasi"><i class="glyphicon glyphicon-trash"></i> Delete</a></li>
                                                </ul>
                                            </div>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php
                if ($isAdmin)
                    echo '<a href="user/adduser.php" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Add new user</a>';
                ?>
            </div>
        </div>
    </div>
</div>


    <!-- Modal Confirmation -->
    <div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-konfirmasi-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white d-flex justify-content-between align-items-center py-2">
                    <h5 class="modal-title mb-0" id="modal-konfirmasi-label">
                        <i class="glyphicon glyphicon-warning-sign"></i> Konfirmasi Penghapusan
                    </h5>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p class="lead">Apakah Anda yakin ingin menghapus data ini?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="icon-warning">
                        <i class="glyphicon glyphicon-trash" style="font-size: 50px; color: red;"></i>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-center">
                    <a href="javascript:;" class="btn btn-danger btn-lg" id="hapus-true-data">
                        <i class="glyphicon glyphicon-trash"></i> Hapus
                    </a>
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove"></i> Batal
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Enzo. All rights reserved.</p>
    </footer>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/hapus.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
</body>

</html>