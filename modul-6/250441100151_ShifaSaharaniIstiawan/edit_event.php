
<?php
session_start();
include 'koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

if(isset($_POST['update'])){
    $nama = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal_event'];
    $lokasi = $_POST['lokasi'];
    $kuota = $_POST['kuota'];

    $stmt = $conn->prepare("
        UPDATE events 
        SET nama_event=?, deskripsi=?, tanggal_event=?, lokasi=?, kuota=? 
        WHERE id_event=?
    ");
    $stmt->bind_param("ssssii", $nama, $deskripsi, $tanggal, $lokasi, $kuota, $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM events WHERE id_event=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Event</h2>

    <form method="POST">
        <input type="text" name="nama_event" value="<?php echo htmlspecialchars($data['nama_event']); ?>" required class="w-full p-2 border mb-3 rounded">
        <textarea name="deskripsi" required class="w-full p-2 border mb-3 rounded"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
        <input type="date" name="tanggal_event" value="<?php echo $data['tanggal_event']; ?>" required class="w-full p-2 border mb-3 rounded">
        <input type="text" name="lokasi" value="<?php echo htmlspecialchars($data['lokasi']); ?>" required class="w-full p-2 border mb-3 rounded">
        <input type="number" name="kuota" value="<?php echo htmlspecialchars($data['kuota']); ?>" required class="w-full p-2 border mb-3 rounded">

        <button type="submit" name="update" class="bg-yellow-500 text-white px-4 py-2 rounded">
            Update
        </button>
        <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </form>
</div>
</body>
</html>