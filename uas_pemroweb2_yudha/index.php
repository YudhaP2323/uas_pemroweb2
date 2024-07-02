<?php
session_start();

// Periksa apakah pengguna sudah login atau belum
if (isset($_SESSION['nim'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UEFA 2024 - Login</title>
</head>
<body>
    <div style="text-align: center; margin-top: 20%;">
        <h1>UEFA 2024 Management System</h1>
        <p>Welcome to UEFA 2024 Management System. Please login to continue.</p>
        <a href="login.php" style="background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 1.2rem;">Login</a>
    </div>
</body>
</html>
