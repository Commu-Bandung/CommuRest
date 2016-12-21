<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pengajuan;

class anggota extends Model
{
    protected $fillable = [
        'nama', 'email', 'password', 'komunitas','kampus','alamatKampus','deskripsi', 'api_token'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pengajuans()
    {
        return $this->hasMany(pengajuan::class);
    }

    public function ownPengajuan(pengajuan $pengajuan)
    {
        return auth()->id() == $pengajuan->anggota->id;
    }
}
