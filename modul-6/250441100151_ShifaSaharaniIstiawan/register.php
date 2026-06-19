
<?php
include 'koneksi.php';

if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (nama,email,password,role) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nama, $email, $password, $role);

    if($stmt->execute()){
        header("Location: login.php");
        exit;
    } else {
        echo "Registrasi gagal!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-xl shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama" required class="w-full p-2 border rounded mb-3">
        <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded mb-3">
        <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded mb-3">
        <button type="submit" name="register" class="w-full bg-blue-500 text-white p-2 rounded">Daftar</button>
    </form>
</div>
</body>
</html>