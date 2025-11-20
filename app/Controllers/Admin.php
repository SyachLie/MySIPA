<?php

namespace App\Controllers; // 1. Namespace CI4

// 2. "use" Model yang akan dipakai
use App\Models\Admin_model;

class Admin extends BaseController // 3. Extends BaseController
{
    // 4. Buat properti untuk menampung model, session, dan db
    protected $adminModel;
    protected $session;
    protected $db; // Untuk statistik dashboard

    public function __construct()
    {
        // 5. Load helper
        helper(['session', 'url']);

        // 6. Buat objek model
        $this->adminModel = new Admin_model();
        
        // 7. Load session
        $this->session = session();
        
        // 8. Load service database (untuk statistik)
        $this->db = \Config\Database::connect();
    }

    // 9. FUNGSI UNTUK CEK LOGIN
    private function cek_login()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') != 'admin') {
            // Kita return true jika GAGAL login
            return true;
        }
        // return false jika BERHASIL login (boleh lanjut)
        return false;
    }

    public function index()
    {
        // 10. Panggil cek_login di awal
        if ($this->cek_login()) {
            return redirect()->to('auth');
        }

        $data['title'] = 'Dashboard Admin';

        // 11. CARA COUNTING DI CI4
        $data['count_mahasiswa'] = $this->db->table('mahasiswa')->countAllResults();
        $data['count_dosen'] = $this->db->table('dosen')->countAllResults();
        $data['count_matkul'] = $this->db->table('mata_kuliah')->countAllResults();
        $data['count_ruangan'] = $this->db->table('ruangan')->countAllResults();

        // 12. CARA LOAD VIEW DI CI4
        return view('admin/a_header', $data)
             . view('admin/a_dashboard', $data)
             . view('admin/a_footer');
    }

    // ================================= MAHASISWA =================================
    public function mahasiswa()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }

        $data['title'] = 'Data Mahasiswa';
        $data['mahasiswa'] = $this->adminModel->get_all_mahasiswa();
        
        return view('admin/a_header', $data)
             . view('admin/mahasiswa_list', $data)
             . view('admin/a_footer');
    }

    public function tambah_mahasiswa()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }

        // 13. CARA AMBIL POST DI CI4
        $nim = $this->request->getPost('nim');
        $nama = $this->request->getPost('nama');
        $password = $this->request->getPost('password');
        
        if (!ctype_digit($nim)) {
            // 14. CARA SET FLASHDATA CI4
            $this->session->setFlashdata('error', 'Gagal! NIM harus berupa angka saja.');
        }
        elseif ($this->adminModel->cek_kode_peran_exists($nim)) {
            $this->session->setFlashdata('error', 'Gagal! NIM ' . $nim . ' sudah terdaftar.');
        } 
        else {
            $this->adminModel->insert_mahasiswa($nim, $nama, $password);
            $this->session->setFlashdata('success', 'Mahasiswa baru berhasil ditambahkan.');
        }
        
        // 15. CARA REDIRECT CI4
        return redirect()->to('admin/mahasiswa');
    }

    public function hapus_mahasiswa($nim)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $this->adminModel->delete_mahasiswa($nim);
        return redirect()->to('admin/mahasiswa');
    }

    public function edit_mahasiswa($nim)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        
        $data['title'] = 'Edit Mahasiswa';
        
        // Ambil data dari model
        $data['mahasiswa'] = $this->adminModel->get_mahasiswa_by_nim($nim); 

        // === PENGAMAN ANTI ERROR ===
        // Cek: Apakah datanya kosong/null?
        if (empty($data['mahasiswa'])) {
            // Kalau kosong, jangan lanjut. Balik ke daftar dengan pesan error.
            session()->setFlashdata('error', 'Data mahasiswa tidak ditemukan (Mungkin ID salah atau sudah dihapus).');
            return redirect()->to('admin/mahasiswa');
        }
        // ===========================

        return view('admin/a_header', $data)
             . view('admin/mahasiswa_edit', $data)
             . view('admin/a_footer');
    }

    public function proses_edit_mahasiswa()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        
        $nim_lama = $this->request->getPost('nim_lama'); // Dari input hidden
        $nim_baru = $this->request->getPost('nim');      // Dari input biasa
        $nama = $this->request->getPost('nama');

        // VALIDASI: Jika NIM diganti, cek apakah NIM baru sudah dipakai orang lain?
        if ($nim_baru != $nim_lama) {
            // Cek ke database
            if ($this->adminModel->cek_kode_peran_exists($nim_baru)) {
                // Kalau ada, kembalikan ke form edit dengan pesan error
                session()->setFlashdata('error', 'Gagal! NIM ' . $nim_baru . ' sudah digunakan mahasiswa lain.');
                return redirect()->to('admin/edit_mahasiswa/' . $nim_lama);
            }
        }

        // Kalau aman, panggil Model Sakti kita
        $this->adminModel->update_mahasiswa($nim_lama, $nim_baru, $nama); 
        
        session()->setFlashdata('success', 'Data mahasiswa berhasil di-update.');
        return redirect()->to('admin/mahasiswa');
    }

    // ================================= DOSEN =================================
    public function dosen()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Data Dosen';
        $data['dosen'] = $this->adminModel->get_all_dosen();
        return view('admin/a_header', $data)
             . view('admin/dosen_list', $data)
             . view('admin/a_footer');
    }

    public function tambah_dosen()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $nidn = $this->request->getPost('nidn');
        $nama = $this->request->getPost('nama');
        $password = $this->request->getPost('password');

        if (!ctype_digit($nidn)) {
            $this->session->setFlashdata('error', 'Gagal! NIDN harus berupa angka saja.');
        }
        elseif ($this->adminModel->cek_kode_peran_exists($nidn)) {
            $this->session->setFlashdata('error', 'Gagal! NIDN ' . $nidn . ' sudah terdaftar.');
        } 
        else {
            $this->adminModel->insert_dosen($nidn, $nama, $password);
            $this->session->setFlashdata('success', 'Dosen baru berhasil ditambahkan.');
        }
        return redirect()->to('admin/dosen');
    }

    public function hapus_dosen($nidn)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $this->adminModel->delete_dosen($nidn);
        return redirect()->to('admin/dosen');
    }

    public function edit_dosen($nidn)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Edit Dosen';
        $data['dosen'] = $this->adminModel->get_dosen_by_nidn($nidn); 

        return view('admin/a_header', $data)
             . view('admin/dosen_edit', $data)
             . view('admin/a_footer');
    }

    public function proses_edit_dosen()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        
        $nidn_lama = $this->request->getPost('nidn_lama');
        $nidn_baru = $this->request->getPost('nidn');
        $nama = $this->request->getPost('nama');

        // VALIDASI: Jika NIDN diganti, cek duplikat
        if ($nidn_baru != $nidn_lama) {
            if ($this->adminModel->cek_kode_peran_exists($nidn_baru)) {
                session()->setFlashdata('error', 'Gagal! NIDN ' . $nidn_baru . ' sudah digunakan dosen lain.');
                return redirect()->to('admin/edit_dosen/' . $nidn_lama);
            }
        }

        // Kalau aman, update
        $this->adminModel->update_dosen($nidn_lama, $nidn_baru, $nama); 
        
        session()->setFlashdata('success', 'Data dosen berhasil di-update.');
        return redirect()->to('admin/dosen');
    }

    // ================================= MATA KULIAH =================================
    public function mata_kuliah()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Data Mata Kuliah';
        $data['matkul_list'] = $this->adminModel->get_all('mata_kuliah'); 
        return view('admin/a_header', $data)
             . view('admin/matkul_list', $data)
             . view('admin/a_footer');
    }

    public function tambah_mata_kuliah()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $kode_mk = $this->request->getPost('kode_mata_kuliah');
        $nama_mk = $this->request->getPost('nama_mata_kuliah');
        $sks = $this->request->getPost('sks');

        if (!ctype_digit($sks)) {
            $this->session->setFlashdata('error', 'Gagal! SKS harus berupa angka.');
        }
        elseif ($this->adminModel->cek_kode_matkul_exists($kode_mk)) {
            $this->session->setFlashdata('error', 'Gagal! Kode MK ' . $kode_mk . ' sudah terdaftar.');
        }
        else {
            $data = [
                'kode_mata_kuliah' => $kode_mk,
                'nama_mata_kuliah' => $nama_mk,
                'sks' => $sks
            ];
            $this->adminModel->insert_mata_kuliah($data);
            $this->session->setFlashdata('success', 'Mata kuliah baru berhasil ditambahkan.');
        }
        return redirect()->to('admin/mata_kuliah');
    }

    public function hapus_mata_kuliah($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $this->adminModel->delete_mata_kuliah($id);
        $this->session->setFlashdata('success', 'Mata kuliah berhasil dihapus.');
        return redirect()->to('admin/mata_kuliah');
    }

    public function edit_mata_kuliah($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Edit Mata Kuliah';
        $data['matkul'] = $this->adminModel->get_mata_kuliah_by_id($id); 

        if (empty($data['matkul'])) {
            $this->session->setFlashdata('error', 'Data mata kuliah tidak ditemukan.');
            return redirect()->to('admin/mata_kuliah');
        }

        return view('admin/a_header', $data)
             . view('admin/matkul_edit', $data)
             . view('admin/a_footer');
    }

    public function proses_edit_mata_kuliah()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $id_mk = $this->request->getPost('id_mata_kuliah');
        $kode_mk = $this->request->getPost('kode_mata_kuliah');
        $nama_mk = $this->request->getPost('nama_mata_kuliah');
        $sks = $this->request->getPost('sks');

        if (!ctype_digit($sks)) {
            $this->session->setFlashdata('error', 'Gagal! SKS harus berupa angka.');
            // 16. Redirect CI4 butuh 'return'
            return redirect()->to('admin/edit_mata_kuliah/' . $id_mk); 
        }

        if ($this->adminModel->cek_kode_matkul_duplikat_update($id_mk, $kode_mk)) {
            $this->session->setFlashdata('error', 'Gagal! Kode MK ' . $kode_mk . ' sudah digunakan oleh mata kuliah lain.');
            return redirect()->to('admin/edit_mata_kuliah/' . $id_mk);
        }

        $data = [
            'kode_mata_kuliah' => $kode_mk,
            'nama_mata_kuliah' => $nama_mk,
            'sks' => $sks
        ];
        $this->adminModel->update_mata_kuliah($id_mk, $data); 
        $this->session->setFlashdata('success', 'Data mata kuliah berhasil di-update.');
        return redirect()->to('admin/mata_kuliah');
    }

    // ================================= RUANGAN =================================
    public function ruangan()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Data Ruangan';
        $data['ruangan'] = $this->adminModel->get_all_ruangan();
        return view('admin/a_header', $data)
             . view('admin/ruangan_list', $data)
             . view('admin/a_footer');
    }

    public function tambah_ruangan()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $nama = $this->request->getPost('nama_ruangan');
        
        if ($this->adminModel->cek_ruangan_exists($nama)) {
            $this->session->setFlashdata('error', 'Gagal! Nama ruangan "' . $nama . '" sudah ada.');
        } else {
            $this->adminModel->insert_ruangan($nama);
            $this->session->setFlashdata('success', 'Ruangan baru berhasil ditambahkan.');
        }
        return redirect()->to('admin/ruangan');
    }

    public function hapus_ruangan($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $this->adminModel->delete_ruangan($id);
        return redirect()->to('admin/ruangan');
    }

    public function edit_ruangan($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Edit Ruangan';
        $data['ruangan'] = $this->adminModel->get_ruangan_by_id($id); 

        if (empty($data['ruangan'])) {
            $this->session->setFlashdata('error', 'Data ruangan tidak ditemukan.');
            return redirect()->to('admin/ruangan');
        }

        return view('admin/a_header', $data)
             . view('admin/ruangan_edit', $data)
             . view('admin/a_footer');
    }

    public function proses_edit_ruangan()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $id_ruangan = $this->request->getPost('id_ruangan');
        $nama_ruangan = $this->request->getPost('nama_ruangan');

        if ($this->adminModel->cek_ruangan_duplikat_update($id_ruangan, $nama_ruangan)) {
            $this->session->setFlashdata('error', 'Gagal! Nama ruangan "' . $nama_ruangan . '" sudah digunakan.');
            return redirect()->to('admin/edit_ruangan/' . $id_ruangan);
        }

        $data = ['nama_ruangan' => $nama_ruangan];
        $this->adminModel->update_ruangan($id_ruangan, $data); 
        $this->session->setFlashdata('success', 'Data ruangan berhasil di-update.');
        return redirect()->to('admin/ruangan');
    }

    // ================================= JADWAL =================================
    public function jadwal()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Data Jadwal Kuliah';
        $data['jadwal'] = $this->adminModel->get_all_jadwal();
        $data['matkul'] = $this->adminModel->get_all('mata_kuliah');
        $data['dosen_list'] = $this->adminModel->get_all('dosen');
        $data['ruangan_list'] = $this->adminModel->get_all('ruangan');

        return view('admin/a_header', $data)
             . view('admin/jadwal_list', $data)
             . view('admin/a_footer');
    }

    public function tambah_jadwal()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_mata_kuliah' => $this->request->getPost('id_mata_kuliah'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'nidn' => $this->request->getPost('nidn'),
            'hari' => $this->request->getPost('hari'),
            'jam' => $this->request->getPost('jam'),
        ];
        $this->adminModel->insert_jadwal($data);
        return redirect()->to('admin/jadwal');
    }

    public function hapus_jadwal($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $this->adminModel->delete_jadwal($id);
        return redirect()->to('admin/jadwal');
    }

    public function edit_jadwal($id)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Edit Jadwal';
        $data['jadwal'] = $this->adminModel->get_jadwal_by_id($id); 
        $data['matkul_list'] = $this->adminModel->get_all('mata_kuliah');
        $data['dosen_list'] = $this->adminModel->get_all('dosen');
        $data['ruangan_list'] = $this->adminModel->get_all('ruangan');

        if (empty($data['jadwal'])) {
            $this->session->setFlashdata('error', 'Data jadwal tidak ditemukan.');
            return redirect()->to('admin/jadwal');
        }

        return view('admin/a_header', $data)
             . view('admin/jadwal_edit', $data)
             . view('admin/a_footer');
    }

    public function proses_edit_jadwal()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $id_jadwal = $this->request->getPost('id_jadwal');

        $data = [
            'id_mata_kuliah' => $this->request->getPost('id_mata_kuliah'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'nidn' => $this->request->getPost('nidn'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'hari' => $this->request->getPost('hari'),
            'jam' => $this->request->getPost('jam')
        ];

        $this->adminModel->update_jadwal($id_jadwal, $data); 
        $this->session->setFlashdata('success', 'Data jadwal berhasil di-update.');
        return redirect()->to('admin/jadwal');
    }

    // ================================= GANTI PASSWORD =================================
    public function form_ganti_password($role, $kode_peran)
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $data['title'] = 'Ganti Password';
        $data['user'] = $this->adminModel->get_user_by_kode_peran($kode_peran);
        $data['role'] = $role;

        return view('admin/a_header', $data)
             . view('admin/ganti_password', $data)
             . view('admin/a_footer');
    }

    public function proses_ganti_password()
    {
        if ($this->cek_login()) { return redirect()->to('auth'); }
        $kode_peran = $this->request->getPost('kode_peran');
        $role = $this->request->getPost('role');
        $new_password = $this->request->getPost('new_password');

        // Fungsi password_hash() ini standar PHP, tidak perlu diubah
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $this->adminModel->update_password($kode_peran, $hashed_password);

        if ($role == 'mahasiswa') {
            return redirect()->to('admin/mahasiswa');
        } else {
            return redirect()->to('admin/dosen');
        }
    }
}