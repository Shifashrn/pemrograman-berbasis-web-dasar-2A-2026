<?php
$timeline = [
    ["tahun" => "2025", "kegiatan" => "Mulai belajar Python"],
    ["tahun" => "2026", "kegiatan" => "Mulai belajar HTML & CSS"],
    ["tahun" => "2026", "kegiatan" => "Membuat website pertama untuk tugas kampus dan praktikum"],
    ["tahun" => "2026", "kegiatan" => "Belajar JavaScript"],
    ["tahun" => "2026", "kegiatan" => "Belajar PHP dasar"]
];

function highlightTahun($tahun, $target) {
    return ($tahun == $target) 
        ? "<span class='font-bold text-blue-600'>$tahun</span>" 
        : $tahun;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-3xl mx-auto bg-white shadow-md mt-10 p-8 rounded-lg">
    
    <!-- Judul -->
    <h1 class="text-3xl font-bold text-center mb-8">
        Timeline Perjalanan Belajar Coding
    </h1>

    <!-- Timeline -->
    <div class="border-l-4 border-blue-500 pl-6">
        <?php foreach ($timeline as $item): ?>
            <div class="mb-6">
                <h2 class="text-xl">
                    <?php echo highlightTahun($item['tahun'], "2025"); ?>
                </h2>
                <p class="text-gray-700">
                    <?php echo $item['kegiatan']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Navigasi -->
    <div class="mt-8 flex justify-between">
        
        <!-- Halaman Sebelumnya -->
        <a href="index.php" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            << Kembali ke Profil
        </a>

        <!-- Halaman Selanjutnya -->
        <a href="blog.php" 
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Blog Developer >>
        </a>

    </div>

</div>

</body>
</html>