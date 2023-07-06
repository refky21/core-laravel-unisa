# Laravel Engine (AdiFW)
Free Engine Content Management System - Biro Sistem Informasi Universitas Ahmad Dahlan
Contact : d3v@bsi.uad.ac.id

## Kebutuhan Server
- PHP >= 8.1
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Curl PHP Extension
- Mysql PHP Extension
- Exif PHP Extension
- Fileinfo PHP Extension

## Cara Instalasi AdiFW lewat zip file

1. Extract file adifw.v.x.x.x.zip di directory web Anda.
2. Buatlah database baru dengan collation utf8mb4_unicode_ci yang nantinya sebagai tempat instalasi tabel-tabel.
3. Melalui browser Anda, masuk ke alamat web dimana file adifw.v.x.x.x.zip tadi diextract.
4. Ikuti petunjuk instalasi dengan benar dan pastikan semua kebutuhan sistem terpenuhi sebelum instalasi.
5. Jika instalasi berhasil, hapuslah atau rename file install.php dan hapus README file ini dari directory web Anda.
6. ADIFW siap untuk digunakan.
7. Semua konfigurasi engine ada pada file .env

## Cara Instalasi ADIFW lewat composer

1. Clone File  [AdiFW](https://github.com/refky21/core-laravel-unisa) di directory web Anda.
2. Buatlah database baru dengan collation utf8mb4_unicode_ci yang nantinya sebagai tempat instalasi tabel-tabel.
3. Buka command line dan masuk ke path hasil clone tadi `/path/adifw` kemudian jalankan ``composer install`` atau ``composer require``
4. Setalah proses composer selesai, melalui browser Anda masuk ke alamat web dimana file AdiFW tadi diClone.
5. Ikuti petunjuk instalasi dengan benar dan pastikan semua kebutuhan sistem terpenuhi sebelum instalasi.
6. Jika instalasi berhasil, hapuslah atau rename file install.php dan hapus README file ini dari directory web Anda.
7. ADIFW siap untuk digunakan.
8. Semua konfigurasi engine ada pada file .env

### Catatan (harap dibaca)

#### Localhost
Jika diinstall pada localhost maka pastikan settingan ``rewrite_module = on``

#### Error 500
Jika terjadi error ``500 internal server error`` (web telah di hosting), kemungkinan karena pada file ``.htaccess`` belum ada baris code ``RewriteBase /``. Solusinya adalah dengan menambahkan baris code ``RewriteBase /`` sebelum code ``RewriteEngine on``

#### Masalah Redirect
Jika terjadi error ``The page isn't redirecting properly`` atau ``This webpage has a redirect loop`` maka langkah yang bisa dilakukan adalah sebagai berikut:
* Coba periksa kembali apakah ``rewrite_module`` sudah on atau belum.
* Periksa apakah file ``.htaccess`` tercopy pada server local atau hosting dengan baik.
* Setelah itu clear cache browser Anda.

#### Kemungkinan File error
Jika terdapat error yang lain, mungkin karena hasil extract file yang tidak sempurna, silahkan replace file-file yang error tersebut.

#### Permission
Untuk di hosting, lakukan perubahan user permission untuk folder-folder berikut menjadi 775 :
* public/uploaded
* public/storage

## Login backend AdiFW
* Masuk ke alamat http://nama.web.anda/admin/login
* Masukkan data login sebagai berikut :
	* Username : seperti yg telah diinputkan pada saat proses instalasi.
	* Password : seperti yg telah diinputkan pada saat proses instalasi.

## API ADIFW
http://nama.web.anda/api/v1

# Terima Kasih Kepada
1. Tuhan Yang Maha Esa
2. Orang-orang yang berada di belakang ADIFW
3. Ynex – Bootstrap Admin Dashboard Template sebagai pembuat template backend v.1.0.1
4. Enews, Magazine, Andia, Brownie, Wiretree, Neon, Pressroom dan Canvas sebagai pembuat template frontend
5. Laravel sebagai engine core untuk ADIFW v.9.0.0
6. StructureCore Installation sebagai referensi modul instalasi
7. Jquery, Bootstrap dan semua plugins jquery yang dipakai pada ADIFW
