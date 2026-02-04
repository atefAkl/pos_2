<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosSession extends Model
{
    use HasFactory, HasUserTracking;

    protected $fillable = [
        'user_id',
        'shift_id',
        'terminal_id',
        'opening_balance',
        'closing_balance',
        'expected_balance',
        'opened_at',
        'closed_at',
        'created_by',
        'updated_by',
        'status',
        'notes',
    ];

    public $timestamps = true;


    protected $casts = [
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'expected_balance' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
