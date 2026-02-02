<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUserTracking;

class Shift extends Model
{
    use HasUserTracking;
    protected $fillable = [
        'name',
        'serial',
        'accountant_id',
        'started_at',
        'ended_at',
        'opening_balance',
        'autoclose',
        'opening_notes',
        'closing_balance',
    ];

    protected $casts = [
        'started_at'        => 'datetime',
        'ended_at'          => 'datetime',
        'opening_balance'   => 'decimal:2',
        'autoclose'         => 'boolean',
        'closing_balance'   => 'decimal:2',
    ];

    public $timestamps = true;

    protected $table = 'shifts';

    /**
     * Get the shift which started today and ended at > now() 
     */
    public static function currentShift(): bool
    {
        return self::where('ended_at', '>', now())->exists();
    }
}
