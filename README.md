# secure_lab
SQL Injection — query dengan input langsung

Pola terdeteksi: penggunaan mysqli_query, mysql_query atau ->query bersama $_GET / $_POST tanpa prepare/parameter binding.

Dampak: attacker dapat menyisipkan SQL berbahaya, membaca/menulis data yang tidak seharusnya, atau menghapus tabel.

Mitigasi (praktis):

Gunakan prepared statements (PDO dengan prepare + bindParam atau mysqli dengan prepare + bind_param).

Validasi dan sanitasi input (tipe data, panjang, pola).

Gunakan least privilege user pada database.

Cross-Site Scripting (XSS) — output user input tanpa sanitasi

Pola terdeteksi: echo atau print langsung dari $_GET/$_POST atau variabel user-driven tanpa htmlspecialchars.

Dampak: injeksi skrip yang berjalan pada browser korban => pencurian session, defacement, phishing.

Mitigasi:

Escape output HTML: htmlspecialchars($s, ENT_QUOTES, 'UTF-8') pada semua data yang disisipkan ke HTML.

Untuk data yang boleh mengandung HTML gunakan sanitizer whitelisting (HTMLPurifier).

Set header Content-Security-Policy bila memungkinkan.

Kerentanan Upload File

Pola terdeteksi: $_FILES dan move_uploaded_file ditemukan; beberapa file menyimpan ke folder uploads/ atau public/ dan tidak terlihat pemeriksaan lanjutan.

Dampak: upload skrip (PHP) yang kemudian dieksekusi — full takeover; penyebaran malware.

Mitigasi:

Validasi ekstensi dan MIME type; verifikasi isi file (mis. cek signature magic bytes).

Simpan file di lokasi non-public, atau ubah nama file menggunakan UUID/uniqid + ekstensi yang diset aman.

Jangan menyimpan file yang dapat dieksekusi (.php, .phtml) di folder yang dilayani web.

Batasi ukuran file, gunakan is_uploaded_file(), set permissions ketat, dan scan virus bila perlu.

Broken Access Control

Pola terdeteksi: indikasi pemeriksaan berbasis client-side (JS) atau hanya mengandalkan parameter tanpa server-side role-check.

Dampak: pengguna biasa bisa mengakses/mengubah resource yang seharusnya terbatas.

Mitigasi:

Selalu lakukan pemeriksaan hak akses di server untuk setiap aksi/read resource.

Gunakan token/UUID untuk resource sensitif dan validasi session di server.

Hindari mengandalkan atribut tersembunyi di formulir atau pemeriksaan JS untuk security.

Perbedaan antara vulnerable vs safe (umum, berdasarkan temuan)

Input handling

Vulnerable: menerima input user langsung ke query atau HTML.

Safe: menggunakan prepared statements untuk DB dan htmlspecialchars untuk output HTML.

File upload

Vulnerable: menyimpan upload ke folder web root dengan nama asli.

Safe: mengganti nama file ke UUID/uniqid, menyimpan di folder non-public, validasi MIME/extension dan menggunakan is_uploaded_file.

Access control

Vulnerable: pemeriksaan akses dilakukan di client atau berdasarkan parameter user-supplied.

Safe: pemeriksaan akses dilakukan di server (session + role checks) pada setiap endpoint.

Error handling

Vulnerable: menampilkan pesan error/dump SQL langsung ke user.

Safe: catat error di log, tampilkan pesan generik ke user.
