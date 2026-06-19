<?php
$artikel = [
    "html" => [
        "judul" => "Belajar HTML Pertama Kali",
        "Tahun" => "2026",
        "isi" => "Saat pertama belajar HTML, saya memahami dasar struktur website seperti heading, paragraf, dan form.",
        "gambar" => "img/html.png",
        "link" => "https://developer.mozilla.org/id/docs/Learn/HTML"
    ],
    "error" => [
        "judul" => "Error Pertama",
        "Tahun" => "2026",
        "isi" => "Error pertama membuat saya belajar pentingnya ketelitian dalam syntax coding.",
        "gambar" => "img/error.png",
        "link" => "https://www.w3schools.com/"
    ]
];

$kutipan = [
    "Coding is problem solving.",
    "Every error makes you better.",
    "Practice makes progress.",
    "Jangan takut bug."
];

$randomQuote = $kutipan[array_rand($kutipan)];
$selected = $_GET['artikel'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto bg-white shadow-md mt-10 p-8 rounded-lg">
    <h1 class="text-3xl font-bold text-center mb-8">Blog Reflektif Developer</h1>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-3">Daftar Artikel:</h2>
        <ul class="list-disc pl-6">
            <?php foreach ($artikel as $key => $data): ?>
                <li>
                    <a href="?artikel=<?php echo $key; ?>" class="text-blue-600 hover:underline">
                        <?php echo $data['judul']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <hr class="my-6">

    <?php if ($selected && array_key_exists($selected, $artikel)): ?>
        <h2 class="text-2xl font-bold"><?php echo $artikel[$selected]['judul']; ?></h2>
        <p class="text-sm text-gray-500 mb-4">Tahun: <?php echo $artikel[$selected]['Tahun']; ?></p>

        <img src="<?php echo $artikel[$selected]['gambar']; ?>" class="w-full max-w-md mb-4 rounded">

        <p class="text-gray-700 mb-4"><?php echo $artikel[$selected]['isi']; ?></p>

        <a href="<?php echo $artikel[$selected]['link']; ?>" target="_blank"
           class="text-blue-600 hover:underline">
           Referensi Tambahan
        </a>

    <?php else: ?>
        <p class="text-gray-600">Pilih artikel untuk membaca cerita developer.</p>
    <?php endif; ?>

    <hr class="my-6">

    <div class="bg-gray-200 p-4 rounded">
        <h3 class="font-semibold">Kutipan Motivasi:</h3>
        <p class="italic">"<?php echo $randomQuote; ?>"</p>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <<< Kembali ke Profil
        </a>
        <a href="timeline.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            << Kembali ke Timeline
        </a>
    </div>
</div>

</body>
</html>