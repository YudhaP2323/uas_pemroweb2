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

// Proses form jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jika tombol Submit ditekan
    if (isset($_POST['submit'])) {
        // Mengambil nilai dari form dengan pemeriksaan isset()
        $nama_group = isset($_POST["nama_group"]) ? $_POST["nama_group"] : '';
        $nama_negara = isset($_POST["nama_negara"]) ? $_POST["nama_negara"] : '';
        $jumlah_menang = isset($_POST["jumlah_menang"]) ? intval($_POST["jumlah_menang"]) : 0;
        $jumlah_seri = isset($_POST["jumlah_seri"]) ? intval($_POST["jumlah_seri"]) : 0;
        $jumlah_kalah = isset($_POST["jumlah_kalah"]) ? intval($_POST["jumlah_kalah"]) : 0;
        $jumlah_poin = ($jumlah_menang * 3) + $jumlah_seri;

        // Menghindari SQL Injection
        $nama_group = mysqli_real_escape_string($conn, $nama_group);
        $nama_negara = mysqli_real_escape_string($conn, $nama_negara);
        $jumlah_menang = mysqli_real_escape_string($conn, $jumlah_menang);
        $jumlah_seri = mysqli_real_escape_string($conn, $jumlah_seri);
        $jumlah_kalah = mysqli_real_escape_string($conn, $jumlah_kalah);
        $jumlah_poin = mysqli_real_escape_string($conn, $jumlah_poin);
        $nama_operator = mysqli_real_escape_string($conn, $_POST["nama_operator"]);
        $nim_mahasiswa = mysqli_real_escape_string($conn, $_POST["nim_mahasiswa"]);

        // Query SQL untuk menyimpan data ke dalam tabel
        $sql = "INSERT INTO klasemen_uefa (nama_group, nama_negara, jumlah_menang, jumlah_seri, jumlah_kalah, jumlah_poin, nama_operator, nim_mahasiswa) VALUES ('$nama_group', '$nama_negara', '$jumlah_menang', '$jumlah_seri', '$jumlah_kalah', '$jumlah_poin', '$nama_operator', '$nim_mahasiswa')";

        if (mysqli_query($conn, $sql)) {
            echo '<div style="color:green;">Data berhasil disimpan.</div>';
        } else {
            echo '<div style="color:red;">Error: ' . mysqli_error($conn) . '</div>';
        }
    }

    // Jika tombol Hapus ditekan
    if (isset($_POST['hapus'])) {
        // Query SQL untuk menghapus semua data dari tabel
        $sql_delete = "DELETE FROM klasemen_uefa";
        if (mysqli_query($conn, $sql_delete)) {
            echo '<div style="color:green;">Data berhasil dihapus.</div>';
        } else {
            echo '<div style="color:red;">Error: ' . mysqli_error($conn) . '</div>';
        }
    }
}

// Query untuk menampilkan data dalam tabel
$result = mysqli_query($conn, "SELECT * FROM klasemen_uefa");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klasemen UEFA 2024</title>
</head>
<body>
    <h1 style="text-align: center;">Data Klasemen UEFA 2024</h1>
    <h2 style="text-align: center;">Per <?php echo date("d F Y H:i:s"); ?></h2>
    <h2 style="text-align: center;">YUDHA PUTRA HERNANDA / 201011402282</h2>

    <h2>Input Data Poin Klasemen</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nama_group">Nama Group:</label>
        <select name="nama_group" id="nama_group">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select><br><br>
        <label for="nama_negara">Nama Negara:</label>
        <select name="nama_negara" id="nama_negara">
            <option value="Jerman">Jerman</option>
            <option value="Swiss">Swiss</option>
            <option value="Skotlandia">Skotlandia</option>
            <option value="Hongaria">Hongaria</option>
            <!-- Tambahkan negara-negara UEFA lainnya sesuai kebutuhan -->
        </select><br><br>
        <label for="jumlah_menang">Jumlah Menang (M):</label>
        <input type="number" name="jumlah_menang" id="jumlah_menang"><br><br>
        <label for="jumlah_seri">Jumlah Seri (S):</label>
        <input type="number" name="jumlah_seri" id="jumlah_seri"><br><br>
        <label for="jumlah_kalah">Jumlah Kalah (K):</label>
        <input type="number" name="jumlah_kalah" id="jumlah_kalah"><br><br>
        <label for="nama_operator">Nama Operator:</label>
        <input type="text" name="nama_operator" id="nama_operator"><br><br>
        <label for="nim_mahasiswa">NIM Mahasiswa:</label>
        <input type="text" name="nim_mahasiswa" id="nim_mahasiswa"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Menampilkan pesan berhasil atau gagal
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['submit']) || isset($_POST['hapus']))) {
        if (isset($_POST['submit']) || isset($_POST['hapus'])) {
            echo "<br>";
        }
    }

    // Menampilkan data dalam tabel
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Data Poin Klasemen</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nama Group</th><th>Nama Negara</th><th>Jumlah Menang (M)</th><th>Jumlah Seri (S)</th><th>Jumlah Kalah (K)</th><th>Jumlah Poin</th><th>Nama Operator</th><th>NIM Mahasiswa</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["nama_group"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nama_negara"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["jumlah_menang"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["jumlah_seri"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["jumlah_kalah"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["jumlah_poin"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nama_operator"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nim_mahasiswa"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data.";
    }

    // Menutup koneksi ke database
    mysqli_close($conn);
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="hapus" value="Hapus Semua Data">
    </form>

    <form method="post" action="export_pdf.php">
        <input type="submit" name="cetak_pdf" value="Cetak Data Klasemen ke PDF">
    </form>

    <form action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
