
<?php
session_start();
include 'koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['submit'])){
    $nama = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal_event'];
    $lokasi = $_POST['lokasi'];
    $kuota = $_POST['kuota'];
    $created_by = $_SESSION['id'];

    $stmt = $conn->prepare("
        INSERT INTO events (nama_event,deskripsi,tanggal_event,lokasi,kuota,created_by) 
        VALUES (?,?,?,?,?,?)
    ");
    $stmt->bind_param("ssssii", $nama, $deskripsi, $tanggal, $lokasi, $kuota, $created_by);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Event Baru</h2>

    <form method="POST">
        <input type="text" name="nama_event" placeholder="Nama Event" required class="w-full p-2 border mb-3 rounded">
        <textarea name="deskripsi" placeholder="Deskripsi" required class="w-full p-2 border mb-3 rounded"></textarea>
        <input type="date" name="tanggal_event" required class="w-full p-2 border mb-3 rounded">
        <input type="text" name="lokasi" placeholder="Lokasi" required class="w-full p-2 border mb-3 rounded">
        <input type="number" name="kuota" placeholder="Kuota" required class="w-full p-2 border mb-3 rounded">

        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
        <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </form>
</div>
</body>
</html>