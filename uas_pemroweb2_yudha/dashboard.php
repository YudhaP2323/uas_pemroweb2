<?php
session_start();
// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Klasemen UEFA 2024</title>
</head>
<body>
    <div>
        <h1>Dashboard - Klasemen UEFA 2024</h1>
        <h2>Per <?php echo date("d F Y H:i:s"); ?></h2>
        <h3>YUDHA PUTRA HERNANDA / 201011402282</h3>
        
        <div>
            <a href="coba.php">Input Data Klasemen</a>
            <a href="view_data.php">Lihat Data Klasemen</a>
            <a href="export_pdf.php">Cetak Data Klasemen ke PDF</a>
        </div>
        
        <div>
            <form action="logout.php">
                <input type="submit" value="Logout">
            </form>
        </div>
    </div>
</body>
</html>
