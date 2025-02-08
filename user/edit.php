<?php
include "../koneksi.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';

// Fetch user data
$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
$user = mysqli_fetch_assoc($result);
$avatar = "../../img/default_profile.png";
if (isset($user["avatar"])) $avatar = "data:image/jpeg;base64," . base64_encode($user["avatar"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Data - Tugas Backend</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../css/style/edit_view.css">
    
</head>
<body>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h3 class="text-center">Edit User Data</h3>
                    <form action="api/userEdit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $user['Id']; ?>">

                        <!-- Avatar Section -->
                        <div class="mb-3 text-center">
                            <img src="<?php echo $avatar ?>" class="avatar-preview" alt="Avatar">
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep unchanged">
                                <span class="input-group-text password-toggle"><i class="bi bi-eye-slash"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                <textarea class="form-control" name="bio" rows="4" ><?php echo $user['bio']; ?></textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom"><i class="bi bi-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Your data has been successfully updated.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Failure -->
    <div class="modal fade" id="failureModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Error!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">There was an error while updating your data. Please try again.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show modal if status is passed
        <?php if (isset($_GET['status'])): ?>
            var modalId = "<?php echo $_GET['status'] == 'success' ? 'successModal' : 'failureModal'; ?>";
            var myModal = new bootstrap.Modal(document.getElementById(modalId));
            myModal.show();
        <?php endif; ?>

        // Toggle Password Visibility
        document.querySelector(".password-toggle").addEventListener("click", function() {
            let passwordField = document.getElementById("password");
            let icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                passwordField.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        });
    </script>

</body>
</html>
