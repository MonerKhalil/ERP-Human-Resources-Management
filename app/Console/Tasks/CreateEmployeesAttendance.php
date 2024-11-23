<?php

namespace App\Console\Tasks;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

class CreateEmployeesAttendance extends MainClassTasks
{
    public function mainProcess(Schedule $schedule){
        $schedule->call(function (){
            do{
                $temp = $this->createEmployees();
            }while(!$temp);
        })->dailyAt("00:30");
//        })->dailyAt("15:42");
    }

    private function createEmployees(){
        try {
            DB::beginTransaction();
            $employees = $this->getEmployeesIDS();
            foreach ($employees as $employee){
                Attendance::create([
                    "employee_id" => $employee,
                ]);
            }
            DB::commit();
            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }
}
