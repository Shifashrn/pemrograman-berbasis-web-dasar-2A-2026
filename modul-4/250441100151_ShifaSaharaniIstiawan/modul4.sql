SELECT kolom 
FROM tabel1 
JOIN tabel2 
ON tabel1.kolom = tabel2.kolom;

SELECT produk.nama_produk, kategori.nama_kategori 
FROM produk
INNER JOIN kategori
ON produk.id_kategori = kategori.id_kategori;

SELECT produk.nama_produk, kategori.nama_kategori 
FROM produk 
LEFT JOIN kategori 
ON produk.id_kategori = kategori.id_kategori;

SELECT produk.nama_produk, kategori.nama_kategori 
FROM produk 
RIGHT JOIN kategori 
ON produk.id_kategori = kategori.id_kategori;

SELECT p.nama_produk, k.nama_kategori 
FROM produk p 
JOIN kategori k 
ON p.id_kategori = k.id_kategori;


CREATE TABLE kategori (
id_kategori INT PRIMARY KEY,
nama_kategori VARCHAR(50)
);


CREATE TABLE produk (
id_produk INT PRIMARY KEY,
nama_produk VARCHAR(100),
harga INT,
id_kategori INT,
FOREIGN KEY (id_kategori)
REFERENCES kategori(id_kategori)
);


CREATE TABLE transaksi ( 
id_transaksi INT PRIMARY KEY, 
id_produk INT, 
jumlah INT, 
FOREIGN KEY (id_produk) 
REFERENCES produk(id_produk) 
);

INSERT INTO kategori VALUES 
(1,'Laptop'), 
(2,'Smartphone'), 
(3,'Aksesoris');

INSERT INTO produk VALUES 
(101,'Laptop Asus',8500000,1), 
(102,'Laptop Lenovo',7500000,1), 
(103,'iPhone 13',12000000,2), 
(104,'Mouse Logitech',150000,3), 
(105,'Keyboard Gaming',500000,3);

INSERT INTO transaksi VALUES 
(1,101,2), 
(2,104,5), 
(3,103,1), 
(4,105,3);

SELECT produk.nama_produk, 
kategori.nama_kategori 
FROM produk 
INNER JOIN kategori 
ON produk.id_kategori = kategori.id_kategori;

SELECT produk.nama_produk, produk.harga, kategori.nama_kategori 
FROM produk 
JOIN kategori 
ON produk.id_kategori = kategori.id_kategori 
WHERE produk.harga > 1000000;

SELECT produk.nama_produk, produk.harga, kategori.nama_kategori 
FROM produk 
JOIN kategori 
ON produk.id_kategori = kategori.id_kategori 
WHERE produk.harga BETWEEN 500000 AND 9000000;

SELECT produk.nama_produk, kategori.nama_kategori 
FROM produk 
JOIN kategori 
ON produk.id_kategori = kategori.id_kategori 
WHERE kategori.nama_kategori IN ('Laptop','Aksesoris');

SELECT produk.nama_produk, ategori.nama_kategori transaksi.jumlah 
FROM transaksi 
JOIN produk  
ON transaksi.id_produk = produk.id_produk 
JOIN kategori  
ON produk.id_kategori = kategori.id_kategori;

SELECT produk.nama_produk, kategori.nama_kategori,   transaksi.jumlah 
FROM transaksi 
JOIN produk 
ON transaksi.id_produk = produk.id_produk 
JOIN kategori 
ON produk.id_kategori = kategori.id_kategori 
WHERE transaksi.jumlah > 2 
ORDER BY transaksi.jumlah DESC;   

SELECT produk.nama_produk, produk.harga,  kategori.nama_kategori 
FROM produk 
JOIN kategori 
ON produk.id_kategori = kategori.id_kategori WHERE kategori.nama_kategori IN ('Laptop','Smartphone')AND produk.harga BETWEEN 7000000 AND 13000000;

SELECT produk.nama_produk, 
       produk.harga, 
       transaksi.jumlah 
FROM transaksi 
JOIN produk 
ON transaksi.id_produk = produk.id_produk 
ORDER BY produk.harga DESC;

SELECT mk.nama_mk, mk.sks, d.nama_dosen
FROM Mata_Kuliah mk
JOIN Dosen d ON mk.id_dosen = d.id_dosen
WHERE d.bidang_keahlian IN ('Pemrograman', 'Basis Data');

SELECT m.nama_mahasiswa, k.id_mata_kuliah
FROM Mahasiswa m
LEFT JOIN KRS k ON m.id_mahasiswa = k.id_mahasiswa;

SELECT m.nama_mahasiswa, mk.nama_mk, k.semester_ambil
FROM KRS k
JOIN Mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
JOIN Mata_Kuliah mk ON k.id_mata_kuliah = mk.id_mata_kuliah
WHERE k.semester_ambil BETWEEN 3 AND 5
ORDER BY k.semester_ambil ASC;

SELECT m.nama_mahasiswa, mk.nama_mk, mk.sks
FROM KRS k
JOIN Mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
JOIN Mata_Kuliah mk ON k.id_mata_kuliah = mk.id_mata_kuliah
WHERE m.program_studi = 'Sistem Informasi' AND mk.sks > 2
ORDER BY mk.sks DESC, m.nama_mahasiswa ASC;

SELECT m.nama_mahasiswa, m.angkatan, mk.nama_mk, d.nama_dosen
FROM KRS k
JOIN Mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
JOIN Mata_Kuliah mk ON k.id_mata_kuliah = mk.id_mata_kuliah
JOIN Dosen d ON mk.id_dosen = d.id_dosen
WHERE m.angkatan BETWEEN 2023 AND 2025 
  AND d.nama_dosen IN ('Dr. Budi', 'Prof. Siti')
ORDER BY m.angkatan DESC;


