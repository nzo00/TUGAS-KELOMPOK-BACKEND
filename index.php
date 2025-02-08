<?php
    session_start();
    if (isset($_GET["action"]) && $_GET["action"] == "logout") {
        session_destroy(); // Destroys the session
        echo "<script>alert('Berhasil logout');</script>";
        header("Location: index.php");
        exit;
    }
    header('Location: dashboard.php');
?>