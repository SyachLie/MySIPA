<?php

namespace App\Models; // 1. Wajib ada namespace

use CodeIgniter\Model; // 2. Wajib "use" Model

class Dosen_model extends Model // 3. Wajib "extends Model"
{
    // Mengambil jadwal mengajar berdasarkan NIDN dosen
    public function get_jadwal_by_nidn($nidn)
    {
        // 4. Cara CI4 memulai query
        $builder = $this->db->table('jadwal j');
        $builder->select('j.id_jadwal, j.nama_kelas, j.hari, j.jam, mk.kode_mata_kuliah, mk.nama_mata_kuliah, r.nama_ruangan');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('ruangan r', 'j.id_ruangan = r.id_ruangan');
        $builder->where('j.nidn', $nidn);
        
        // 5. Ganti ->result() menjadi ->getResultArray()
        return $builder->get()->getResultArray();
    }

    // Mengambil detail satu jadwal
    public function get_jadwal_detail($id_jadwal)
    {
        $builder = $this->db->table('jadwal j');
        $builder->select('mk.nama_mata_kuliah, j.nama_kelas, j.hari, j.jam');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->where('j.id_jadwal', $id_jadwal);
        
        // 6. Ganti ->row() menjadi ->getRowArray() (untuk 1 baris data)
        return $builder->get()->getRowArray();
    }

    // Mengambil daftar mahasiswa yang ada di satu jadwal kelas
    public function get_mahasiswa_by_jadwal($id_jadwal)
    {
        $builder = $this->db->table('rencana_studi rs');
        $builder->select('m.nim, m.nama, rs.id_rencana_studi, rs.nilai_huruf');
        $builder->join('mahasiswa m', 'rs.nim = m.nim');
        $builder->where('rs.id_jadwal', $id_jadwal);
        
        // 7. Ganti ->result() menjadi ->getResultArray()
        return $builder->get()->getResultArray();
    }

    // Mengambil semua opsi nilai dari tabel nilai_mutu
    public function get_nilai_mutu()
    {
        // 8. Cara CI4 untuk query simpel
        return $this->db->table('nilai_mutu')->get()->getResultArray();
    }

    // Update nilai untuk satu mahasiswa
    public function update_nilai($id_rencana_studi, $nilai_huruf)
    {
        $data = [ // Ganti array() jadi []
            'nilai_huruf' => $nilai_huruf
        ];
        
        // 9. Cara CI4 untuk update
        $this->db->table('rencana_studi')
                 ->where('id_rencana_studi', $id_rencana_studi)
                 ->update($data);
    }
}