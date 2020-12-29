<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mMahasiswa extends Model
{
    // nama tabel
    protected $table = 'mahasiswa';

    // PK
    protected $primaryKey = 'nim';
}
