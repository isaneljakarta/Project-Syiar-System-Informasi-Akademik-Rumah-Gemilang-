<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'kategori',
        'isi',
        'tanggal_kegiatan',
        'waktu_kegiatan',
        'lokasi',
        'penyelenggara',
        'pekan_ke',
        'is_pinned',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil pengumuman aktif untuk ditampilkan pada Landing Page
     */
    public function getActiveAnnouncements(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('is_pinned', 'DESC')
                    ->orderBy('tanggal_kegiatan', 'ASC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil seluruh pengumuman untuk manajemen admin
     */
    public function getAllAnnouncements(): array
    {
        return $this->orderBy('is_pinned', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
