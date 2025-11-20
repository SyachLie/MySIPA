# MySIPA - Sistem Informasi Perkuliahan Akademik 🎓

MySIPA adalah aplikasi Sistem Informasi Akademik berbasis web yang dibangun menggunakan **CodeIgniter 4**. Aplikasi ini dirancang untuk menangani proses akademik mulai dari pengelolaan data master, penyusunan KRS (Kartu Rencana Studi) oleh mahasiswa, hingga pengisian nilai oleh dosen.

### Login Page
<img width="600" alt="Screenshot 2025-11-20 212940" src="https://github.com/user-attachments/assets/f08bcfcb-f62d-4609-9829-7b9577bc1ec5" />

### Dashboard Mahasiswa
<img width="600" alt="Screenshot 2025-11-20 213325" src="https://github.com/user-attachments/assets/51b61c2f-e33b-4c68-84b9-824af63d4991" />

### Dashboard Dosen
<img width="600" alt="Screenshot 2025-11-20 213430" src="https://github.com/user-attachments/assets/57cb90c1-3a2b-4b71-bedc-0455caecb720" />

### Dashboard Admin
<img width="600" alt="Screenshot 2025-11-20 213451" src="https://github.com/user-attachments/assets/5fabfebc-582e-4c26-9024-97ca4e776bf7" />

## 🚀 Fitur Utama

### 1. 🔐 Autentikasi & Keamanan
* **Multi-Level Login:** Admin, Dosen, dan Mahasiswa.
* **Password Hashing:** Menggunakan `password_hash()` (Bcrypt) untuk keamanan maksimal.
* **Session Management:** Proteksi rute menggunakan Filter/Middleware (cegah akses paksa tanpa login).

### 2. 👤 Panel Mahasiswa
* **Dashboard Informatif:** Ringkasan IPK, Total SKS, dan jumlah mata kuliah yang diambil.
* **KRS Online:**
    * Melihat jadwal tersedia.
    * Validasi otomatis (cegah pengambilan mata kuliah ganda).
    * Hapus mata kuliah dengan konfirmasi keamanan.
* **KHS (Kartu Hasil Studi):** Melihat riwayat nilai dan status kelulusan mata kuliah.

### 3. 👨‍🏫 Panel Dosen
* **Jadwal Mengajar:** Melihat daftar kelas yang diampu.
* **Input Nilai:** Form pengisian nilai mahasiswa yang terintegrasi.
* **Notifikasi:** Pop-up sukses saat nilai berhasil disimpan.

### 4. 🛠 Panel Admin
* **CRUD Data Master:**
    * Mahasiswa & Dosen (Dilengkapi fitur **Safe Update** untuk ganti NIM/NIDN tanpa merusak relasi data).
    * Mata Kuliah.
    * Ruangan.
    * Jadwal Kuliah.
* **Manajemen User:** Reset password pengguna.
* **Statistik Dashboard:** Penghitungan real-time jumlah data.

### 5. 🎨 UI/UX Modern
* **Sidebar Navigation:** Menu navigasi responsif di sebelah kiri.
* **SweetAlert2:** Notifikasi pop-up yang interaktif untuk Sukses, Gagal, dan Konfirmasi Hapus.
* **Clean Design:** Tampilan tabel dan form yang rapi dan mudah dibaca.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.4.0, CodeIgniter 4 Framework.
* **Database:** MySQL.
* **Frontend:** HTML5, CSS3 (Custom Modern Style), JavaScript.
* **Libraries:** SweetAlert2 (untuk notifikasi).

---

## 💻 Cara Instalasi (Localhost)

Ikuti langkah ini untuk menjalankan projek di komputer lokal:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username-kamu/mysipa.git](https://github.com/username-kamu/mysipa.git)
    ```

2.  **Konfigurasi Database**
    * Buat database baru di phpMyAdmin bernama `mysipa`.
    * Impor file `mysipa.sql` (sertakan file ini di repo kamu) ke dalam database tersebut.

3.  **Konfigurasi Environment (CI4)**
    * Copy file `env` menjadi `.env`.
    * Buka file `.env` dan atur konfigurasi berikut:
        ```ini
        CI_ENVIRONMENT = development
        app.baseURL = 'http://localhost/mysipa/public/'
        
        database.default.hostname = localhost
        database.default.database = mysipa
        database.default.username = root
        database.default.password = 
        database.default.DBDriver = MySQLi
        ```

4.  **Jalankan Aplikasi**
    * Jika menggunakan WampServer, pindahkan folder `mysipa` ke dalam folder `C:\wamp64\www\`.
    * Akses melalui browser: `http://localhost/mysipa/public/`.

---

## 📂 Struktur Database

Aplikasi ini menggunakan tabel relasional utama:
* `user`: Menyimpan data login (username, password, role).
* `mahasiswa` & `dosen`: Data profil.
* `mata_kuliah`: Data kurikulum.
* `jadwal`: Menghubungkan Dosen, Matkul, dan Ruangan.
* `rencana_studi`: Transaksi pengambilan KRS dan Nilai.

---

## 🔑 Akun Demo (Default)

Gunakan akun berikut untuk pengujian:

| Role | Username / ID | Password |
| :--- | :--- | :--- |
| **Admin** | ******* | `*******` |
| **Mahasiswa** | ******* | `*******` |
| **Dosen** | ******* | `*******` |

---

## 📝 Lisensi

Projek ini dibuat untuk tujuan pendidikan/tugas akhir. Silakan dikembangkan lebih lanjut.

---

*Dibuat dengan ❤️ oleh [SyachLie]*
