<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nama tabel
    protected $primaryKey = 'id_user'; // Primary key

    protected $allowedFields = [
        'username',
        'password',
        'email',
        'id_level',
        'created_at',
        'updated_at'
    ]; // Kolom-kolom yang diizinkan untuk diubah/dimasukkan

    protected $useTimestamps = false; // Karena `created_at` dan `updated_at` otomatis diisi oleh database

}
