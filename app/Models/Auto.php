<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Auto
 *
 * @property $id
 * @property $marca
 * @property $modelo
 * @property $año
 * @property $kilometros
 * @property $motor
 * @property $combustible
 * @property $precio
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Auto extends Model
{
    
    static $rules = [
		'marca' => 'required',
		'modelo' => 'required',
		'año' => 'required',
		'kilometros' => 'required',
		'motor' => 'required',
		'combustible' => 'required',
		'precio' => 'required',
		'descripcion' => 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['marca','modelo','año','kilometros','motor','combustible','precio', 'descripcion', 'activo'];



}
