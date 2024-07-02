<?php
session_start();
// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit;
}

// Informasi koneksi ke database MySQL
$servername = "localhost"; // Ganti dengan nama host database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$dbname = "bola"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Menampilkan data dalam tabel
$result = mysqli_query($conn, "SELECT * FROM klasemen_uefa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lihat Data Klasemen - UEFA 2024</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout {
            text-align: right;
        }
        .logout form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lihat Data Klasemen - UEFA 2024</h1>
            <h2>Per <?php echo date("d F Y H:i:s"); ?></h2>
            <h3>DINDA NUR ISHMA / 201011401432</h3>
        </div>

        <div class="table-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Nama Group</th><th>Nama Negara</th><th>Jumlah Menang (M)</th><th>Jumlah Seri (S)</th><th>Jumlah Kalah (K)</th><th>Jumlah Poin</th><th>Nama Operator</th><th>NIM Mahasiswa</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["nama_group"] . "</td>";
                    echo "<td>" . $row["nama_negara"] . "</td>";
                    echo "<td>" . $row["jumlah_menang"] . "</td>";
                    echo "<td>" . $row["jumlah_seri"] . "</td>";
                    echo "<td>" . $row["jumlah_kalah"] . "</td>";
                    echo "<td>" . $row["jumlah_poin"] . "</td>";
                    echo "<td>" . $row["nama_operator"] . "</td>";
                    echo "<td>" . $row["nim_mahasiswa"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Tidak ada data klasemen yang tersedia.";
            }
            ?>
        </div>

        <div class="logout">
            <form action="logout.php" method="post">
                <input type="submit" value="Logout">
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Menutup koneksi ke database
mysqli_close($conn);
?>
