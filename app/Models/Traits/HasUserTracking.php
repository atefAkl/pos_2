<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasUserTracking
{
    /**
     * Boot the trait
     */
    protected static function bootHasUserTracking()
    {
        static::creating(function ($model) {
            if (Auth::check() && !$model->isDirty('created_by')) {
                $model->created_by = Auth::id();
            }
            if (Auth::check() && !$model->isDirty('updated_by')) {
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && !$model->isDirty('updated_by')) {
                $model->updated_by = Auth::id();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check() && !$model->isDirty('updated_by')) {
                $model->updated_by = Auth::id();
                $model->save();
            }
        });
    }

    /**
     * Get the user who created the model
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the model
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
