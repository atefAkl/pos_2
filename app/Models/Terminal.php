<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    //
    protected $fillable = [
        'name',
        's_number',
        'printer',
        'pos_device',
        'occupation',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function posSessions()
    {
        return $this->hasMany(PosSession::class);
    }

    public function isOccupied()
    {
        return $this->occupation;
    }
}
