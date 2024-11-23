<?php

namespace App\Console;

use App\Console\Tasks\CreateEmployeesAttendance;
use App\Console\Tasks\CreateEmployeesPayroll;
use App\Console\Tasks\EditSalaryEmployees;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        #create rows employees in table attendance in every day
        (new CreateEmployeesAttendance())->mainProcess($schedule);
        #create rows employees in table payroll in every month
        (new CreateEmployeesPayroll())->mainProcess($schedule);
        #edit salary employees in table payroll in every day
        (new EditSalaryEmployees())->mainProcess($schedule);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
