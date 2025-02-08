<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/style/add_view.css">
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4>Add New User</h4>
            </div>
            <div class="card-body">
                <form id="dataForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" name="email" maxlength="255" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" name="password" id="password" maxlength="255" required>
                            <span class="input-group-text password-toggle"><i class="bi bi-eye-slash"></i></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                            <input type="text" class="form-control" name="bio">
                        </div>
                    </div>

                    <!-- Avatar Upload Section -->
                    <div class="mb-3">
                        <label class="form-label">Avatar</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input type="file" class="form-control" name="avatar" accept="image/*" required>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Add User</button>
                        <button type="reset" class="btn btn-secondary mt-2"><i class="bi bi-arrow-repeat"></i> Reset Form</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Response section -->
        <div id="response" class="mt-3 text-center"></div>

        <div class="text-center mt-3">
            <a href="/index.php" class="btn btn-outline-danger"><i class="bi bi-list"></i> View Data</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#dataForm").on("submit", function(event) {
                event.preventDefault();

                // Check if avatar is selected and is a valid image
                var avatarFile = $("input[name='avatar']")[0].files[0];
                if (avatarFile) {
                    if (!avatarFile.type.startsWith("image/")) {
                        alert("Please upload a valid image file.");
                        return;
                    }
                }

                // Create FormData to handle file uploads
                var formData = new FormData(this);

                $.ajax({
                    url: "api/userAdd.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false, // Important for file upload
                    processData: false, // Important for file upload
                    success: function(response) {
                        if (!response.error) {
                            $("#response").html('<div class="alert alert-success">' + response.msg + '</div>');
                            $("#dataForm")[0].reset();
                            setTimeout(() => { window.location.href = '/index.php'; }, 1500);
                        } else {
                            $("#response").html('<div class="alert alert-danger">' + response.msg + '</div>');
                        }
                    },
                    error: function(xhr, status, err) {
                        $("#response").html('<div class="alert alert-danger">Failed to save data. ' + err + '</div>');
                    }
                });
            });

            $(".password-toggle").click(function() {
                let passwordField = $("#password");
                let icon = $(this).find("i");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    icon.removeClass("bi-eye-slash").addClass("bi-eye");
                } else {
                    passwordField.attr("type", "password");
                    icon.removeClass("bi-eye").addClass("bi-eye-slash");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
