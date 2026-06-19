<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

// ==============================
// USER DAFTAR EVENT + KUOTA BERKURANG
// ==============================
if(isset($_POST['daftar_event']) && $_SESSION['role'] == 'user'){
    $event_id = (int)$_POST['event_id'];
    $user_id  = $_SESSION['id'];

    // Cek apakah user sudah daftar event ini
    $cek = $conn->prepare("
        SELECT id_daftar 
        FROM pendaftaran_event 
        WHERE user_id=? AND event_id=?
    ");
    $cek->bind_param("ii", $user_id, $event_id);
    $cek->execute();
    $hasil = $cek->get_result();

    if($hasil->num_rows == 0){

        // Cek kuota event
        $cekKuota = $conn->prepare("
            SELECT kuota 
            FROM events 
            WHERE id_event=?
        ");
        $cekKuota->bind_param("i", $event_id);
        $cekKuota->execute();
        $dataKuota = $cekKuota->get_result()->fetch_assoc();

        if($dataKuota && $dataKuota['kuota'] > 0){

            // Simpan pendaftaran
            $stmt = $conn->prepare("
                INSERT INTO pendaftaran_event (user_id, event_id) 
                VALUES (?,?)
            ");
            $stmt->bind_param("ii", $user_id, $event_id);
            $stmt->execute();

            // Kurangi kuota
            $updateKuota = $conn->prepare("
                UPDATE events 
                SET kuota = kuota - 1 
                WHERE id_event=?
            ");
            $updateKuota->bind_param("i", $event_id);
            $updateKuota->execute();

            echo "<script>alert('Pendaftaran berhasil!'); window.location='dashboard.php';</script>";
            exit;

        } else {
            echo "<script>alert('Kuota event sudah habis!');</script>";
        }

    } else {
        echo "<script>alert('Anda sudah terdaftar pada event ini!');</script>";
    }
}

// ==============================
// AMBIL DATA EVENT
// ==============================
$result = $conn->query("SELECT * FROM events ORDER BY tanggal_event ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Campus Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Campus Event</h1>
            <p class="text-gray-600 mt-1">
                Halo, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong>
                (<?php echo htmlspecialchars($_SESSION['role']); ?>)
            </p>
        </div>

        <a href="logout.php"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
           Logout
        </a>
    </div>

    <!-- ADMIN BUTTON -->
    <?php if($_SESSION['role'] == 'admin'): ?>
        <a href="tambah_event.php"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-block mb-4">
           + Tambah Event
        </a>
    <?php endif; ?>

    <!-- ========================= -->
    <!-- DAFTAR EVENT -->
    <!-- ========================= -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gray-200 px-4 py-3">
            <h2 class="text-xl font-bold">Daftar Event Kampus</h2>
        </div>

        <table class="w-full">
            <tr class="bg-gray-100 text-center">
                <th class="p-3">Nama Event</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Sisa Kuota</th>
                <th>Aksi</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="text-center border-b hover:bg-gray-50">
                <td class="p-3 font-semibold">
                    <?php echo htmlspecialchars($row['nama_event']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['deskripsi']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['tanggal_event']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['lokasi']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['kuota']); ?>
                </td>

                <td class="p-2">

                    <!-- ADMIN -->
                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <a href="edit_event.php?id=<?php echo $row['id_event']; ?>"
                           class="text-yellow-500 font-semibold">
                           Edit
                        </a>
                        |
                        <a href="hapus_event.php?id=<?php echo $row['id_event']; ?>"
                           class="text-red-500 font-semibold"
                           onclick="return confirm('Yakin ingin menghapus event ini?')">
                           Hapus
                        </a>

                    <!-- USER -->
                    <?php else: ?>

                        <?php if($row['kuota'] > 0): ?>
                        <form method="POST">
                            <input type="hidden" name="event_id" value="<?php echo $row['id_event']; ?>">
                            <button type="submit"
                                    name="daftar_event"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">
                                Daftar
                            </button>
                        </form>
                        <?php else: ?>
                            <span class="text-red-500 font-semibold">Penuh</span>
                        <?php endif; ?>

                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- ========================= -->
    <!-- RIWAYAT USER -->
    <!-- ========================= -->
    <?php if($_SESSION['role'] == 'user'): ?>
    <div class="mt-10 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-green-200 px-4 py-3">
            <h2 class="text-xl font-bold text-green-900">Riwayat Event Saya</h2>
        </div>

        <?php
        $user_id = $_SESSION['id'];

        $riwayat = $conn->prepare("
            SELECT events.nama_event, events.deskripsi, events.tanggal_event, events.lokasi, pendaftaran_event.tanggal_daftar
            FROM pendaftaran_event
            JOIN events ON pendaftaran_event.event_id = events.id_event
            WHERE pendaftaran_event.user_id=?
            ORDER BY pendaftaran_event.tanggal_daftar DESC
        ");

        $riwayat->bind_param("i", $user_id);
        $riwayat->execute();
        $hasil_riwayat = $riwayat->get_result();
        ?>

        <?php if($hasil_riwayat->num_rows > 0): ?>
        <table class="w-full">
            <tr class="bg-green-100 text-center">
                <th class="p-3">Nama Event</th>
                <th>Deskripsi</th>
                <th>Tanggal Event</th>
                <th>Lokasi</th>
                <th>Tanggal Daftar</th>
            </tr>

            <?php while($r = $hasil_riwayat->fetch_assoc()): ?>
            <tr class="text-center border-b">
                <td class="p-2"><?php echo htmlspecialchars($r['nama_event']); ?></td>
                <td><?php echo htmlspecialchars($r['deskripsi']); ?></td>
                <td><?php echo htmlspecialchars($r['tanggal_event']); ?></td>
                <td><?php echo htmlspecialchars($r['lokasi']); ?></td>
                <td><?php echo htmlspecialchars($r['tanggal_daftar']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <div class="p-4 text-center text-gray-500">
                Belum ada event yang didaftarkan.
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- ========================= -->
    <!-- RIWAYAT ADMIN -->
    <!-- ========================= -->
    <?php if($_SESSION['role'] == 'admin'): ?>
    <div class="mt-10 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-blue-200 px-4 py-3">
            <h2 class="text-xl font-bold text-blue-900">Riwayat Semua Pendaftar Event</h2>
        </div>

        <?php
        $adminRiwayat = $conn->query("
            SELECT users.nama, users.email, events.nama_event, events.tanggal_event, events.lokasi, pendaftaran_event.tanggal_daftar
            FROM pendaftaran_event
            JOIN users ON pendaftaran_event.user_id = users.id
            JOIN events ON pendaftaran_event.event_id = events.id_event
            ORDER BY pendaftaran_event.tanggal_daftar DESC
        ");
        ?>

        <?php if($adminRiwayat->num_rows > 0): ?>
        <table class="w-full">
            <tr class="bg-blue-100 text-center">
                <th class="p-3">Nama User</th>
                <th>Email</th>
                <th>Nama Event</th>
                <th>Tanggal Event</th>
                <th>Lokasi</th>
                <th>Tanggal Daftar</th>
            </tr>

            <?php while($a = $adminRiwayat->fetch_assoc()): ?>
            <tr class="text-center border-b hover:bg-blue-50">
                <td class="p-2 font-semibold"><?php echo htmlspecialchars($a['nama']); ?></td>
                <td><?php echo htmlspecialchars($a['email']); ?></td>
                <td><?php echo htmlspecialchars($a['nama_event']); ?></td>
                <td><?php echo htmlspecialchars($a['tanggal_event']); ?></td>
                <td><?php echo htmlspecialchars($a['lokasi']); ?></td>
                <td><?php echo htmlspecialchars($a['tanggal_daftar']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <div class="p-4 text-center text-gray-500">
                Belum ada user yang mendaftar event.
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>
</body>
</html>