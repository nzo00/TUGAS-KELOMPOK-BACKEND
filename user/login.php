<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT password FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $hashed_password);
            mysqli_stmt_fetch($stmt);

            if (md5($password) === $hashed_password) {
                $_SESSION['user'] = $email;

                // Remember Me functionality
                if (isset($_POST['remember_me'])) {
                    setcookie('user_email', $email, time() + (86400 * 30), "/");
                } else {
                    setcookie('user_email', '', time() - 3600, "/");
                }

                header("Location: /dashboard.php");
                exit;
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style/login_view.css">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="login-container">
                    <h2 class="text-center">User Login</h2>

                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i class="bi bi-eye password-eye" id="togglePassword" style="font-size: 18px;"></i>
                        </div>

                        <div class="mb-3 form-check remember-me">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me" <?php echo isset($_COOKIE['user_email']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            togglePassword.classList.toggle('bi-eye'); // Switch to open eye
            togglePassword.classList.toggle('bi-eye-slash'); // Switch to closed eye
        });
    </script>
</body>
</html>
