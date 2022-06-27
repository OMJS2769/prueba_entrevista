<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'dni',
        'id_reg',
        'id_com',
        'email',
        'name',
        'last_name',
        'address',
        'date_reg',
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

    public function commune()
    {
        return $this->belongsTo(
            'App\Models\Commune',
            'id_com',
            'id'
        )
            ->withDefault();
    }
}
