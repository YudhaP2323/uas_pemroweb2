<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "bola"); // Ubah sesuai konfigurasi database Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['group_id'];
    $country_name = $_POST['country_name'];
    $wins = $_POST['wins'];
    $draws = $_POST['draws'];
    $losses = $_POST['losses'];
    $points = ($wins * 3) + ($draws);

    $stmt = $mysqli->prepare("INSERT INTO countries (group_id, country_name, wins, draws, losses, points) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isiiii', $group_id, $country_name, $wins, $draws, $losses, $points);
    $stmt->execute();
    $stmt->close();

    echo "Data berhasil ditambahkan!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Masukkan Data Grup</title>
</head>
<body>
    <form method="POST" action="">
        Nama Group:
        <select name="group_id">
            <?php
            $result = $mysqli->query("SELECT * FROM groups");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select><br>
        Nama Negara: <input type="text" name="country_name" required><br>
        Menang: <input type="number" name="wins" min="0" required><br>
        Seri: <input type="number" name="draws" min="0" required><br>
        Kalah: <input type="number" name="losses" min="0" required><br>
        <input type="submit" value="Masukkan Data">
    </form>
</body>
</html>
