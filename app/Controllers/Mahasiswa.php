<?php

namespace App\Controllers;

// 1. Kita "use" Model yang akan dipakai
use App\Models\Mahasiswa_model;

class Mahasiswa extends BaseController
{
    // 2. Buat properti untuk menampung model & session
    protected $mahasiswaModel;
    protected $session;

    public function __construct()
    {
        // 3. Load helper
        helper(['session', 'url']);

        // 4. Buat objek model di construct
        $this->mahasiswaModel = new Mahasiswa_model();
        
        // 5. Load session (meski bisa juga pakai helper session() langsung)
        $this->session = session();
    }

    // 6. FUNGSI UNTUK CEK LOGIN
    // Di CI4, redirect tidak bisa ditaruh di __construct
    // Jadi kita buat fungsi privat dan panggil di tiap fungsi utama
    private function cek_login()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') != 'mahasiswa') {
            // Jika tidak login, paksa redirect
            // Kita return true jika GAGAL login, untuk di-cek di fungsi lain
            return true;
        }
        // return false jika BERHASIL login (boleh lanjut)
        return false;
    }

    // Halaman Dashboard Mahasiswa
    public function index()
    {
        // Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Dashboard Mahasiswa';
        $nim = $this->session->get('kode_peran');

        // 1. AMBIL DATA MATA KULIAH YG SUDAH DIAMBIL
        // Kita pakai fungsi yang sama dengan KHS
        $data['riwayat_mk'] = $this->mahasiswaModel->get_khs_by_nim($nim);

        // 2. HITUNG RINGKASAN (TOTAL SKS & IPK)
        $total_sks = 0;
        $total_bobot = 0;
        $jumlah_matkul = count($data['riwayat_mk']);

        foreach ($data['riwayat_mk'] as $row) {
            // Hanya hitung jika sudah ada nilai mutu (sudah dinilai)
            if (!empty($row['nilai_mutu'])) {
                $total_sks += $row['sks'];
                $total_bobot += ($row['sks'] * $row['nilai_mutu']);
            }
        }

        // Simpan hasil hitungan ke data
        $data['total_sks_diambil'] = $total_sks;
        $data['total_matkul'] = $jumlah_matkul;
        // Rumus IPK: Total Bobot / Total SKS
        $data['ipk_saat_ini'] = ($total_sks > 0) ? number_format($total_bobot / $total_sks, 2) : '0.00';

        return view('mahasiswa/m_header', $data)
             . view('mahasiswa/m_dashboard', $data)
             . view('mahasiswa/m_footer');
    }

    // Halaman Rencana Studi (KRS)
    public function krs()
    {
        // Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Kartu Rencana Studi (KRS)';
        // 8. CARA AMBIL SESSION DI CI4
        $nim = $this->session->get('kode_peran');

        // 9. Panggil model dari properti
        $data['jadwal_tersedia'] = $this->mahasiswaModel->get_jadwal_tersedia();
        $data['krs_mahasiswa'] = $this->mahasiswaModel->get_krs_by_nim($nim);

        return view('mahasiswa/m_header', $data)
             . view('mahasiswa/m_krs', $data)
             . view('mahasiswa/m_footer');
    }

    // Fungsi untuk menambah mata kuliah ke KRS
    public function tambah_krs($id_jadwal)
    {
        // Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $nim = $this->session->get('kode_peran');

        // 1. CEK VALIDASI DUPLIKAT
        // Panggil fungsi yang baru kita buat di model
        if ($this->mahasiswaModel->cek_krs_duplikat($nim, $id_jadwal)) {
            
            // JIKA SUDAH ADA: Tampilkan pesan error
            session()->setFlashdata('error', 'Gagal! Kamu sudah mengambil mata kuliah ini.');
            
        } else {
            
            // JIKA BELUM ADA: Lakukan proses simpan
            $this->mahasiswaModel->tambah_krs($nim, $id_jadwal);
            session()->setFlashdata('success', 'Berhasil menambahkan mata kuliah ke KRS.');
            
        }
        
        // Kembali ke halaman KRS
        return redirect()->to('mahasiswa/krs');
    }

    // Fungsi untuk menghapus mata kuliah dari KRS
    public function hapus_krs($id_rencana_studi)
    {
        // Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $this->mahasiswaModel->hapus_krs($id_rencana_studi);
        
        // TAMBAHKAN FLASH DATA INI
        session()->setFlashdata('success', 'Mata kuliah berhasil dihapus dari KRS.');

        return redirect()->to('mahasiswa/krs');
    }

    // Halaman Hasil Studi (KHS)
    public function khs()
    {
        // Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Kartu Hasil Studi (KHS)';
        $nim = $this->session->get('kode_peran');

        $data['khs'] = $this->mahasiswaModel->get_khs_by_nim($nim);

        // Menghitung IPK
        $total_sks = 0;
        $total_bobot = 0;
        
        // 11. !! PERINGATAN BESAR !!
        // Model CI4 default-nya mengembalikan ARRAY, bukan OBJEK.
        // Jadi $row->sks akan ERROR. Ganti semua jadi $row['sks']
        foreach ($data['khs'] as $row) {
            if (!empty($row['nilai_mutu'])) { // Ganti dari -> ke ['...']
                $total_sks += $row['sks'];     // Ganti dari -> ke ['...']
                $total_bobot += ($row['sks'] * $row['nilai_mutu']); // Ganti
            }
        }

        $data['total_sks'] = $total_sks;
        $data['ipk'] = ($total_sks > 0) ? ($total_bobot / $total_sks) : 0;

        return view('mahasiswa/m_header', $data)
             . view('mahasiswa/m_khs', $data)
             . view('mahasiswa/m_footer');
    }
}