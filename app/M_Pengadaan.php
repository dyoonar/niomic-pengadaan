<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Pengadaan extends Model
{
    protected $table = 'tbl_pengadaan';
    protected $primaryKey = 'id_pengadaan';
    protected $fillable = ['id_pengadaan', 'nama_pengadaan','deskripsi','gambar', 'status', 'anggaran'];
}
