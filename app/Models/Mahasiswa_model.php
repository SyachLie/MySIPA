<?php

namespace App\Models; // 1. Wajib ada namespace

use CodeIgniter\Model; // 2. Wajib "use" Model

class Mahasiswa_model extends Model // 3. Wajib "extends Model"
{
    // Kita tidak perlu __construct() karena $this->db
    // sudah otomatis tersedia dari "extends Model"

    // Mengambil semua jadwal yang tersedia
    public function get_jadwal_tersedia()
    {
        // 4. Cara CI4 memulai query (lebih jelas)
        $builder = $this->db->table('jadwal j'); 
        $builder->select('j.*, mk.kode_mata_kuliah, mk.nama_mata_kuliah, mk.sks, d.nama as nama_dosen, r.nama_ruangan');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('dosen d', 'j.nidn = d.nidn');
        $builder->join('ruangan r', 'j.id_ruangan = r.id_ruangan');
        
        // 5. Cara CI4 mengambil hasil (sebagai Array)
        return $builder->get()->getResultArray();
    }

    // Mengambil KRS yang sudah diambil mahasiswa
    public function get_krs_by_nim($nim)
    {
        $builder = $this->db->table('rencana_studi rs');
        $builder->select('rs.id_rencana_studi, j.nama_kelas, mk.kode_mata_kuliah, mk.nama_mata_kuliah, mk.sks, d.nama as nama_dosen');
        $builder->join('jadwal j', 'rs.id_jadwal = j.id_jadwal');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('dosen d', 'j.nidn = d.nidn');
        $builder->where('rs.nim', $nim);
        
        // 6. Ganti jadi ->getResultArray()
        return $builder->get()->getResultArray();
    }

    // Menyimpan data KRS baru
    public function tambah_krs($nim, $id_jadwal)
    {
        // Ganti array() jadi [] (standar PHP baru, opsional)
        $data = [ 
            'nim' => $nim,
            'id_jadwal' => $id_jadwal
        ];
        
        // 7. Cara CI4 untuk insert
        $this->db->table('rencana_studi')->insert($data);
    }

    // Menghapus data KRS
    public function hapus_krs($id_rencana_studi)
    {
        // 8. Cara CI4 untuk delete (lebih rapi)
        $this->db->table('rencana_studi')
                 ->where('id_rencana_studi', $id_rencana_studi)
                 ->delete();
    }

    // FUNGSI BARU: Cek apakah mahasiswa sudah mengambil Mata Kuliah yang sama
    public function cek_krs_duplikat($nim, $id_jadwal_baru)
    {
        // 1. Kita cari tahu dulu, jadwal yang mau diambil itu ID Mata Kuliah-nya apa?
        $jadwal = $this->db->table('jadwal')
                       ->where('id_jadwal', $id_jadwal_baru)
                       ->get()->getRowArray();
        
        if (!$jadwal) {
            return false; // Jaga-jaga kalau jadwal ga ketemu
        }

        $id_mata_kuliah_baru = $jadwal['id_mata_kuliah'];

        // 2. Sekarang cek di tabel rencana_studi
        // Apakah mahasiswa ini (nim) sudah punya KRS dengan id_mata_kuliah yang sama?
        $builder = $this->db->table('rencana_studi rs');
        $builder->join('jadwal j', 'rs.id_jadwal = j.id_jadwal');
        $builder->where('rs.nim', $nim);
        $builder->where('j.id_mata_kuliah', $id_mata_kuliah_baru);
        
        // Hitung jumlahnya
        return $builder->countAllResults() > 0; // True jika sudah ada, False jika belum
    }

    // Mengambil data KHS untuk perhitungan IPK
    public function get_khs_by_nim($nim)
    {
        $builder = $this->db->table('rencana_studi rs');
        $builder->select('mk.kode_mata_kuliah, mk.nama_mata_kuliah, mk.sks, rs.nilai_huruf, nm.nilai_mutu');
        $builder->join('jadwal j', 'rs.id_jadwal = j.id_jadwal');
        $builder->join('mata_kuliah mk', 'j.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('nilai_mutu nm', 'rs.nilai_huruf = nm.nilai_huruf', 'left'); 
        $builder->where('rs.nim', $nim);
        
        // 9. Ganti jadi ->getResultArray()
        // Ini penting agar $row['sks'] di Controller tidak error
        return $builder->get()->getResultArray();
    }
}