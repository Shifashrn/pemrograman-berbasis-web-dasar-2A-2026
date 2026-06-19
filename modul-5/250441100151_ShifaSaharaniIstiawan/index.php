<?php
function tampilkanArray($data) {
    return implode (", ", array_map('trim', $data));
}

$hasil = "";
$pengalaman = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $framework = $_POST['framework'];
    $cerita = $_POST['cerita'];
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $minat = $_POST['minat'] ?? "";
    $skill = $_POST['skill'] ?? "";

    if (!empty($framework) && !empty($cerita) && !empty($tools) && !empty($minat) && !empty($skill)) {
        
        $frameworkArray = explode(",", $framework);

        $hasil = "
        <div class='mt-8'>
            <h3 class='text-2xl font-bold mb-4'>Hasil Input Developer</h3>
            <table class='w-full border border-collapse'>
                <tr class='border'>
                    <th class='border p-2 bg-gray-200'>Framework/Tools</th>
                    <td class='border p-2'>" . tampilkanArray($frameworkArray) . "</td>
                </tr>
                <tr class='border'>
                    <th class='border p-2 bg-gray-200'>Tools Penunjang</th>
                    <td class='border p-2'>" . tampilkanArray($tools) . "</td>
                </tr>
                <tr class='border'>
                    <th class='border p-2 bg-gray-200'>Minat Bidang</th>
                    <td class='border p-2'>$minat</td>
                </tr>
                <tr class='border'>
                    <th class='border p-2 bg-gray-200'>Tingkat Skill</th>
                    <td class='border p-2'>$skill</td>
                </tr>
            </table>
        </div>
        ";

        if (count($frameworkArray) > 2) {
            $hasil .= "<p class='text-green-600 font-semibold mt-4'>Skill Anda cukup luas di bidang development!</p>";
        }

        $pengalaman = "
        <div class='mt-6 bg-gray-100 p-4 rounded'>
            <h4 class='font-bold'>Cerita Pengalaman:</h4>
            <p>$cerita</p>
        </div>
        ";

    } else {
        $hasil = "<p class='text-red-500 font-bold mt-4'>Semua input wajib diisi!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Interaktif Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto bg-white shadow-md mt-10 p-8 rounded-lg">
    
    <h1 class="text-3xl font-bold text-center mb-8">
        Profil Interaktif Developer Pemula
    </h1>

    <!-- Profil Statis -->
   <div class="w-full flex justify-center mb-8">
    <table class="w-full border border-collapse">
        <tr class="bg-gray-200">
            <th class="border p-2 text-center">Data</th>
            <th class="border p-2 text-center">Informasi</th>
        </tr>
        <tr>
            <td class="border p-2 text-center">Nama</td>
            <td class="border p-2 text-center">Shifa Istiawan</td>
        </tr>
        <tr>
            <td class="border p-2 text-center">ID Developer</td>
            <td class="border p-2 text-center">DEV2026</td>
        </tr>
        <tr>
            <td class="border p-2 text-center">Kota/Tgl Lahir</td>
            <td class="border p-2 text-center">Bangkalan, 18 Mei 2006</td>
        </tr>
        <tr>
            <td class="border p-2 text-center">Email</td>
            <td class="border p-2 text-center">shifasaaahrn1@gmail.com</td>
        </tr>
        <tr>
            <td class="border p-2 text-center">No. WhatsApp</td>
            <td class="border p-2 text-center">085904262215</td>
        </tr>
    </table>
</div>

    <!-- Form -->
    <form method="POST" class="space-y-6">

        <div>
            <label class="font-semibold">Framework/Tools dikuasai (pisahkan dengan koma):</label>
            <input type="text" name="framework" class="w-full border p-2 rounded mt-2" placeholder="HTML, CSS, PHP">
        </div>

        <div>
            <label class="font-semibold">Cerita pengalaman:</label>
            <textarea name="cerita" class="w-full border p-2 rounded mt-2"></textarea>
        </div>

        <div>
            <label class="font-semibold">Tools Penunjang:</label>
            <div class="mt-2 space-y-1">
                <label class="block"><input type="checkbox" name="tools[]" value="VS Code"> VS Code</label>
                <label class="block"><input type="checkbox" name="tools[]" value="GitHub"> GitHub</label>
                <label class="block"><input type="checkbox" name="tools[]" value="Figma"> Figma</label>
                 <label class="block"><input type="checkbox" name="tools[]" value="Figma"> Postman</label>
            </div>
        </div>

        <div>
            <label class="font-semibold">Minat Bidang:</label>
            <div class="mt-2">
                <label class="mr-4"><input type="radio" name="minat" value="Frontend"> Frontend</label>
                <label class="mr-4"><input type="radio" name="minat" value="Backend"> Backend</label>
                <label><input type="radio" name="minat" value="Fullstack"> Fullstack</label>
            </div>
        </div>

        <div>
            <label class="font-semibold">Tingkat Skill Coding:</label>
            <select name="skill" class="w-full border p-2 rounded mt-2">
                <option value="">-- Pilih --</option>
                <option value="Dasar">Dasar</option>
                <option value="Cukup">Cukup</option>
                <option value="Profesional">Profesional</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Kirim
        </button>
    </form>

    <!-- Output -->
    <?php
    echo $hasil;
    echo $pengalaman;
    ?>

    <!-- Navigasi -->
    <div class="mt-8 text-right">
        <a href="timeline.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Timeline Belajar >>
        </a>
    </div>

</div>

</body>
</html>