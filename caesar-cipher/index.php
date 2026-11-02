<?php
$error = $_GET['error'] ?? '';
$status = $_GET['status'] ?? '';

$hasil = '';
$lokasi_file = __DIR__ . '/hasil.txt';

if ($status === 'berhasil' && file_exists($lokasi_file)) {
    $hasil = file_get_contents($lokasi_file);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Caesar Cipher</title>
</head>
<body>

    <h1>Praktikum Caesar Cipher</h1>

    <form action="cipher-proses.php" method="post">

        <label for="teks">Teks:</label><br>
        <textarea id="teks" name="teks" rows="4" cols="50"
        required></textarea>
        <br><br>

        <label for="kunci">Kunci (1-25):</label>
        <input type="number" id="kunci" name="kunci"
        min="1" max="25" required>
        <br><br>

        <label for="aksi">Aksi:</label>
        <select name="aksi" id="aksi" required>
            <option value="enkripsi">Enkripsi</option>
            <option value="dekripsi">Dekripsi</option>
        </select>
        <br><br>

        <input type="submit" value="Proses">

    </form>

    <?php
    if ($error !== '') {
        echo "<h2>Error:</h2>";
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }

    if ($status === 'berhasil' && $hasil !== '') {
        echo "<h2>Hasil:</h2>";
        echo "<pre>" . htmlspecialchars($hasil) . "</pre>";
        echo '<a href="hasil.txt" download>Unduh hasil.txt</a>';
    }
    ?>

</body>
</html>
