
<?php
session_start();
include 'koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM events WHERE id_event=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit;
?>