<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "bola");

if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $mysqli->real_escape_string($_POST['nim']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $result = $mysqli->query("SELECT * FROM users WHERE nim='$nim' AND password='$password'");
    
    if ($result->num_rows == 1) {
        $_SESSION['nim'] = $nim;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "NIM atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p.error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
</body>
</html>
