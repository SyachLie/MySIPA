<?php
namespace App\Models; // 1. Tambah Namespace

use CodeIgniter\Model; // 2. Pakai Model CI4

class User_model extends Model // 3. Extends ke Model CI4
{
    // 4. Definisikan tabelmu (CI4 jadi pintar)
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    // 5. Kita buat ulang fungsi check_user
    public function check_user($kode_peran)
    {
        // Query builder-nya 99% sama
        return $this->where('kode_peran', $kode_peran)
                    ->first(); // first() lebih gampang daripada get()->row()
    }
}