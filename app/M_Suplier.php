<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Suplier extends Model
{
    protected $table = 'tbl_suplier';
    protected $primaryKey = 'id_suplier';
    protected $fillable = ['id_suplier', 'nama_usaha','email','alamat','no_npwp','password', 'status', 'token'];
}
