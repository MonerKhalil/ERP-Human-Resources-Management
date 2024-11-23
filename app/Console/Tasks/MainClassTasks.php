<?php

namespace App\Console\Tasks;

use App\Models\Employee;
use Illuminate\Console\Scheduling\Schedule;

abstract class MainClassTasks
{
    public abstract function mainProcess(Schedule $schedule);

    public function getEmployeesIDS(){
        return Employee::query()->pluck("id")->toArray();
    }

    public function getEmployees(){
        return Employee::with("work_setting")->get();
    }

}
