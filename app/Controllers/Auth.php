<?php
namespace App\Controllers;

// 1. Kita "use" semua yang kita butuhkan
use App\Models\User_model;

class Auth extends BaseController // 2. Extends ke BaseController
{
    protected $userModel; // Buat properti untuk model
    protected $session;   // Buat properti untuk session

    public function __construct()
    {
        // 3. Load helper (session & url)
        helper(['session', 'url']);

        // 4. Buat objek model (bukan $this->load)
        $this->userModel = new User_model();
        // 5. Load session
        $this->session = session();
    }

    // Menampilkan halaman login
    public function index()
    {
        // 6. Logika session-nya beda
        if ($this->session->get('role')) {
            return $this->redirect_user();
        }
        // 7. Cara load view
        return view('view_login');
    }

    // Proses login
    public function proses_login()
    {
        // 8. Cara ambil POST
        $kode_peran = $this->request->getPost('kode_peran');
        $password = $this->request->getPost('password');

        $user = $this->userModel->check_user($kode_peran);

        // 9. Ambil data dari objek (jika pakai first())
        if ($user && password_verify($password, $user['password'])) {

            $session_data = [
                'id_user'   => $user['id_user'],
                'nama_user' => $user['nama_user'],
                'role'      => $user['role'],
                'kode_peran'=> $user['kode_peran'],
                'logged_in' => TRUE
            ];
            // 10. Cara set session
            $this->session->set($session_data);

            return $this->redirect_user();

        } else {
            // 11. Cara set flashdata
            $this->session->setFlashdata('error', 'NIM/NIDN atau Password salah!');
            // 12. Cara redirect
            return redirect()->to(base_url('auth'));
        }
    }

    // Fungsi redirect (beda cara panggil)
    private function redirect_user()
    {
        $role = $this->session->get('role');
        if ($role == 'mahasiswa') {
            return redirect()->to(base_url('mahasiswa'));
        } elseif ($role == 'dosen') {
            return redirect()->to(base_url('dosen'));
        } elseif ($role == 'admin') {
            return redirect()->to(base_url('admin'));
        } else {
            return $this->logout();
        }
    }

    // Fungsi logout
    public function logout()
    {
        // 13. Cara destroy session
        $this->session->destroy();
        return redirect()->to(base_url('auth'));
    }
}