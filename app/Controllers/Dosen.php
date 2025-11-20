<?php

namespace App\Controllers;

// 1. "use" Model yang akan dipakai
use App\Models\Dosen_model;

class Dosen extends BaseController
{
    // 2. Buat properti untuk menampung model & session
    protected $dosenModel;
    protected $session;

    public function __construct()
    {
        // 3. Load helper
        helper(['session', 'url']);

        // 4. Buat objek model di construct
        $this->dosenModel = new Dosen_model();
        
        // 5. Load session
        $this->session = session();
    }

    // 6. FUNGSI UNTUK CEK LOGIN
    // Sama seperti Mahasiswa, redirect tidak bisa di __construct
    private function cek_login()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') != 'dosen') {
            // Kita return true jika GAGAL login
            return true;
        }
        // return false jika BERHASIL login (boleh lanjut)
        return false;
    }

    // Halaman utama Dosen: menampilkan jadwal mengajar
    public function index()
    {
        // 7. Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Jadwal Mengajar';
        // 8. CARA AMBIL SESSION DI CI4
        $nidn = $this->session->get('kode_peran');

        // 9. Panggil model dari properti
        $data['jadwal_mengajar'] = $this->dosenModel->get_jadwal_by_nidn($nidn);

        // 10. CARA LOAD VIEW DI CI4
        return view('dosen/d_header', $data)
             . view('dosen/jadwal_mengajar', $data)
             . view('dosen/d_footer');
    }

    // Halaman untuk melihat detail jadwal dan mengisi nilai
    public function isi_nilai($id_jadwal)
    {
        // 11. Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Isi Nilai Mahasiswa';

        $data['id_jadwal_form'] = $id_jadwal;

        // Panggil model
        $data['jadwal'] = $this->dosenModel->get_jadwal_detail($id_jadwal);
        $data['mahasiswa_kelas'] = $this->dosenModel->get_mahasiswa_by_jadwal($id_jadwal);
        $data['opsi_nilai'] = $this->dosenModel->get_nilai_mutu();

        // Load view
        return view('dosen/d_header', $data)
             . view('dosen/isi_nilai', $data)
             . view('dosen/d_footer');
    }

    // Proses untuk menyimpan nilai
    public function simpan_nilai()
    {
        // 12. Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        // 13. CARA AMBIL POST DI CI4
        $id_jadwal = $this->request->getPost('id_jadwal');
        $id_rs_array = $this->request->getPost('id_rs');
        $nilai_array = $this->request->getPost('nilai');

        if (!empty($id_rs_array)) {
            for ($i = 0; $i < count($id_rs_array); $i++) {
                $this->dosenModel->update_nilai($id_rs_array[$i], $nilai_array[$i]);
            }
            // 14. CARA SET FLASHDATA DI CI4
            $this->session->setFlashdata('success', 'Nilai berhasil disimpan!');
        } else {
            $this->session->setFlashdata('error', 'Tidak ada data mahasiswa untuk disimpan.');
        }

        // 15. CARA REDIRECT DI CI4
        return redirect()->to('dosen/isi_nilai/' . $id_jadwal);
    }
}