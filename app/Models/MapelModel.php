<?php namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id';

    public function getJumlahMapel()
    {
        return $this->countAll(); // Menghitung total baris di tabel mapel
    }
}