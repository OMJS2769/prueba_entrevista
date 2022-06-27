<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_reg',
        'description',
        'status'
    ];

    public function region()
    {
        return $this->belongsTo(
            'App\Models\Region',
            'id_reg',
            'id'
        )
            ->withDefault();
    }
}
