<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auto;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes';
    protected $fillable = [
        'path',
        'idAuto',
        'orden'
    ];

    public function autos()
    {
        return $this->belongsTo(Auto::class);
    }
}
