<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneratedPasswordModel extends Model
{
    protected $table = 'generated_passwords'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key

    protected $allowedFields = [
        'password',
        'created_at',
        'user_id'
    ]; // Kolom-kolom yang diizinkan untuk diubah/dimasukkan

    protected $useTimestamps = false; // Karena `created_at` otomatis diisi oleh database

    /**
     * Ambil semua password yang dihasilkan oleh pengguna tertentu
     * 
     * @param int $userId
     * @return array
     */
    public function getPasswordsByUserId($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}
