<?php
// ======================================================
// FILE: peserta_event.php
// KHUSUS ADMIN MELIHAT USER YANG MENDAFTAR EVENT
// ======================================================
session_start();
include 'koneksi.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$data = $conn->query("
    SELECT 
        pendaftaran_event.id_daftar,
        users.nama,
        users.email,
        events.nama_event,
        events.tanggal_event,
        pendaftaran_event.tanggal_daftar
    FROM pendaftaran_event
    JOIN users ON pendaftaran_event.user_id = users.id
    JOIN events ON pendaftaran_event.event_id = events.id_event
    ORDER BY pendaftaran_event.tanggal_daftar DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Peserta Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">

    <div class="flex justify-between mb-4">
        <h1 class="text-3xl font-bold">Daftar Peserta Event</h1>

        <a href="dashboard.php"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
           Kembali
        </a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <tr class="bg-gray-200">
            <th class="p-3">Nama User</th>
            <th>Email</th>
            <th>Nama Event</th>
            <th>Tanggal Event</th>
            <th>Tanggal Daftar</th>
        </tr>

        <?php while ($row = $data->fetch_assoc()): ?>
        <tr class="text-center border-b">
            <td class="p-3"><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_event']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_event']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_daftar']); ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>
</body>
</html>