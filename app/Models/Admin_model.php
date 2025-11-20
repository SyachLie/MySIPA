<?php

namespace App\Models; // 1. Namespace CI4

use CodeIgniter\Model; // 2. "use" Model

class Admin_model extends Model // 3. "extends Model"
{
    // Fungsi umum untuk mengambil semua data dari sebuah tabel
    public function get_all($table)
    {
        // 4. Cara CI4 ambil data (jadi array)
        return $this->db->table($table)->get()->getResultArray();
    }

    // ================================= MAHASISWA =================================
    public function get_all_mahasiswa()
    {
        return $this->db->table('mahasiswa')->get()->getResultArray();
    }

    public function insert_mahasiswa($nim, $nama, $password)
    {
        // 5. Mulai Transaction
        $this->db->transStart();
        
        $this->db->table('mahasiswa')->insert(['nim' => $nim, 'nama' => $nama]);
        $user_data = [
            'nama_user'  => $nama,
            'role'       => 'mahasiswa',
            'kode_peran' => $nim,
            'password'   => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->db->table('user')->insert($user_data);
        
        // 6. Selesaikan Transaction
        $this->db->transComplete();
    }

    public function delete_mahasiswa($nim)
    {
        $this->db->transStart();
        $this->db->table('user')->where('kode_peran', $nim)->delete();
        $this->db->table('mahasiswa')->where('nim', $nim)->delete();
        $this->db->transComplete();
    }

    public function get_mahasiswa_by_nim($nim)
    {
        // 7. Ganti ->row() jadi ->getRowArray()
        return $this->db->table('mahasiswa')->where('nim', $nim)->get()->getRowArray();
    }

    public function update_mahasiswa($nim_lama, $nim_baru, $nama)
    {
        // Mulai Transaksi (Biar aman, kalau gagal 1 batal semua)
        $this->db->transStart();
        
        // 1. Matikan Cek Foreign Key (Supaya database gak teriak error)
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // 2. Update Tabel MAHASISWA
        $this->db->table('mahasiswa')
                 ->where('nim', $nim_lama)
                 ->update([
                     'nim' => $nim_baru,
                     'nama' => $nama
                 ]);

        // 3. Update Tabel USER (Biar loginnya ganti juga)
        $this->db->table('user')
                 ->where('kode_peran', $nim_lama)
                 ->update([
                     'kode_peran' => $nim_baru,
                     'nama_user' => $nama
                 ]);

        // 4. Update Tabel RENCANA_STUDI (Biar KRS gak hilang)
        $this->db->table('rencana_studi')
                 ->where('nim', $nim_lama)
                 ->update(['nim' => $nim_baru]);

        // 5. Hidupkan lagi Cek Foreign Key (Wajib!)
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
        $this->db->transComplete();
    }

    // ================================= DOSEN =================================
    public function get_all_dosen()
    {
        return $this->db->table('dosen')->get()->getResultArray();
    }

    public function insert_dosen($nidn, $nama, $password)
    {
        $this->db->transStart();
        $this->db->table('dosen')->insert(['nidn' => $nidn, 'nama' => $nama]);
        $user_data = [
            'nama_user'  => $nama,
            'role'       => 'dosen',
            'kode_peran' => $nidn,
            'password'   => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->db->table('user')->insert($user_data);
        $this->db->transComplete();
    }

    public function delete_dosen($nidn)
    {
        $this->db->transStart();
        $this->db->table('user')->where('kode_peran', $nidn)->delete();
        $this->db->table('dosen')->where('nidn', $nidn)->delete();
        $this->db->transComplete();
    }

    public function get_dosen_by_nidn($nidn)
    {
        return $this->db->table('dosen')->where('nidn', $nidn)->get()->getRowArray();
    }

    public function update_dosen($nidn_lama, $nidn_baru, $nama)
    {
        $this->db->transStart();
        
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // 1. Update Tabel DOSEN
        $this->db->table('dosen')
                 ->where('nidn', $nidn_lama)
                 ->update([
                     'nidn' => $nidn_baru,
                     'nama' => $nama
                 ]);

        // 2. Update Tabel USER
        $this->db->table('user')
                 ->where('kode_peran', $nidn_lama)
                 ->update([
                     'kode_peran' => $nidn_baru,
                     'nama_user' => $nama
                 ]);

        // 3. Update Tabel JADWAL (Biar jadwal mengajarnya ikut pindah)
        $this->db->table('jadwal')
                 ->where('nidn', $nidn_lama)
                 ->update(['nidn' => $nidn_baru]);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
        $this->db->transComplete();
    }

    // ================================= MATA KULIAH =================================
    public function cek_kode_matkul_exists($kode_mk)
    {
        // 8. Ganti ->num_rows() jadi ->countAllResults()
        $count = $this->db->table('mata_kuliah')->where('kode_mata_kuliah', $kode_mk)->countAllResults();
        return ($count > 0);
    }

    public function insert_mata_kuliah($data)
    {
        $this->db->table('mata_kuliah')->insert($data);
    }

    public function delete_mata_kuliah($id)
    {
        $this->db->table('mata_kuliah')->where('id_mata_kuliah', $id)->delete();
    }

    public function get_mata_kuliah_by_id($id)
    {
        return $this->db->table('mata_kuliah')->where('id_mata_kuliah', $id)->get()->getRowArray();
    }

    public function cek_kode_matkul_duplikat_update($id_mk, $kode_mk)
    {
        $count = $this->db->table('mata_kuliah')
                         ->where('kode_mata_kuliah', $kode_mk)
                         ->where('id_mata_kuliah !=', $id_mk)
                         ->countAllResults();
        return ($count > 0);
    }

    public function update_mata_kuliah($id_mk, $data)
    {
        $this->db->table('mata_kuliah')->where('id_mata_kuliah', $id_mk)->update($data);
    }

    // ================================= RUANGAN =================================
    public function get_all_ruangan()
    {
        return $this->db->table('ruangan')->get()->getResultArray();
    }

    public function insert_ruangan($nama)
    {
        $this->db->table('ruangan')->insert(['nama_ruangan' => $nama]);
    }

    public function delete_ruangan($id)
    {
        $this->db->table('ruangan')->where('id_ruangan', $id)->delete();
    }

    public function get_ruangan_by_id($id)
    {
        return $this->db->table('ruangan')->where('id_ruangan', $id)->get()->getRowArray();
    }

    public function update_ruangan($id, $data)
    {
        $this->db->table('ruangan')->where('id_ruangan', $id)->update($data);
    }

    public function cek_ruangan_exists($nama_ruangan)
    {
        $count = $this->db->table('ruangan')->where('nama_ruangan', $nama_ruangan)->countAllResults();
        return ($count > 0);
    }

    public function cek_ruangan_duplikat_update($id_ruangan, $nama_ruangan)
    {
        $count = $this->db->table('ruangan')
                         ->where('nama_ruangan', $nama_ruangan)
                         ->where('id_ruangan !=', $id_ruangan)
                         ->countAllResults();
        return ($count > 0);
    }

    // ================================= JADWAL =================================
    public function get_all_jadwal()
    {
        // 9. Query join versi CI4
        $builder = $this->db->table('jadwal j');
        $builder->select('j.*, mk.nama_mata_kuliah, d.nama as nama_dosen, r.nama_ruangan');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('dosen d', 'j.nidn = d.nidn');
        $builder->join('ruangan r', 'j.id_ruangan = r.id_ruangan');
        return $builder->get()->getResultArray();
    }

    public function insert_jadwal($data)
    {
        $this->db->table('jadwal')->insert($data);
    }

    public function delete_jadwal($id)
    {
        $this->db->table('jadwal')->where('id_jadwal', $id)->delete();
    }

    public function get_jadwal_by_id($id)
    {
        return $this->db->table('jadwal')->where('id_jadwal', $id)->get()->getRowArray();
    }

    public function update_jadwal($id, $data)
    {
        $this->db->table('jadwal')->where('id_jadwal', $id)->update($data);
    }

    // ================================= GANTI PASSWORD & USER =================================
    public function get_user_by_kode_peran($kode_peran)
    {
        return $this->db->table('user')->where('kode_peran', $kode_peran)->get()->getRowArray();
    }

    public function update_password($kode_peran, $hashed_password)
    {
        $this->db->table('user')->where('kode_peran', $kode_peran)->update(['password' => $hashed_password]);
    }

    public function cek_kode_peran_exists($kode_peran)
    {
        $count = $this->db->table('user')->where('kode_peran', $kode_peran)->countAllResults();
        return ($count > 0);
    }
}