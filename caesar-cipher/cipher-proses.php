<?php

function caesarCipher($teks, $kunci, $modus) {

    $hasil = '';

    $alfabetBesar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $alfabetKecil = 'abcdefghijklmnopqrstuvwxyz';

    for ($i = 0; $i < strlen($teks); $i++) {

        $char = $teks[$i];

        $indexBesar = strpos($alfabetBesar, $char);
        $indexKecil = strpos($alfabetKecil, $char);

        if ($indexBesar !== false) {

            if ($modus === 'enkripsi') {
                $newIndex = ($indexBesar + $kunci) % 26;
            } else {
                $newIndex = ($indexBesar - $kunci + 26) % 26;
            }

            $hasil .= $alfabetBesar[$newIndex];

        } elseif ($indexKecil !== false) {

            if ($modus === 'enkripsi') {
                $newIndex = ($indexKecil + $kunci) % 26;
            } else {
                $newIndex = ($indexKecil - $kunci + 26) % 26;
            }

            $hasil .= $alfabetKecil[$newIndex];

        } else {

            $hasil .= $char;

        }
    }

    return $hasil;
}

// Memastikan data dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Mengambil data dari formulir
$teks_input = trim($_POST['teks'] ?? '');
$kunci_raw = $_POST['kunci'] ?? '';
$aksi_input = $_POST['aksi'] ?? '';

// Validasi teks kosong
if ($teks_input === '') {

    header("Location: index.php?error=" . urlencode("Teks tidak boleh kosong."));
    exit();

}

// Validasi kunci harus angka
$kunci_input = filter_var($kunci_raw, FILTER_VALIDATE_INT);

if ($kunci_input === false) {

    header("Location: index.php?error=" . urlencode("Kunci harus berupa angka."));
    exit();

}

// Validasi kunci antara 1 dan 25
if ($kunci_input < 1 || $kunci_input > 25) {

    header("Location: index.php?error=" . urlencode("Kunci harus antara 1 dan 25."));
    exit();

}

// Validasi pilihan aksi
if ($aksi_input !== 'enkripsi' && $aksi_input !== 'dekripsi') {

    header("Location: index.php?error=" . urlencode("Pilihan aksi tidak valid."));
    exit();

}

// Memproses Caesar Cipher
$hasil_akhir = caesarCipher(
    $teks_input,
    $kunci_input,
    $aksi_input
);

// Menyimpan hasil ke file TXT
$lokasi_file = __DIR__ . '/hasil.txt';

if (file_put_contents($lokasi_file, $hasil_akhir) === false) {

    header("Location: index.php?error=" . urlencode("Gagal menyimpan file TXT."));
    exit();

}

// Kembali ke halaman utama
header("Location: index.php?status=berhasil");
exit();

?>
