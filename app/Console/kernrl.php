<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Jobs
use App\Jobs\OpenShiftJob;
use App\Jobs\CloseShiftJob;
use App\Jobs\OpenSessionJob;
use App\Jobs\CloseSessionJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // تشغيل كل دقيقة للتحقق من الوردية
        $schedule->job(new OpenShiftJob)->everyMinute();
        $schedule->job(new CloseShiftJob)->everyMinute();

        // تشغيل كل دقيقة للتحقق من الجلسات
        $schedule->job(new OpenSessionJob)->everyMinute();
        $schedule->job(new CloseSessionJob)->everyMinute();

        // مثال: تنظيف سجلات قديمة يوميًا
        //
    }
}
