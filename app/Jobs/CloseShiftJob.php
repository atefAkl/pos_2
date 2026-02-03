<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Shift;

class CloseShiftJob implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentShift = Shift::where('ended_at', '<', now())->where('is_current', 1)->first();
        if ($currentShift) {
            $currentShift->update(['is_current' => false]);
        }
    }
}
