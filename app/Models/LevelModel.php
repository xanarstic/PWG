<?php

namespace App\Models;

use CodeIgniter\Model;

class LevelModel extends Model
{
    protected $table = 'level'; // Nama tabel
    protected $primaryKey = 'id_level'; // Primary key

    protected $allowedFields = ['nama_level']; // Kolom yang diizinkan untuk diubah/dimasukkan

    protected $useTimestamps = false; // Tidak ada kolom timestamp di tabel ini

}
