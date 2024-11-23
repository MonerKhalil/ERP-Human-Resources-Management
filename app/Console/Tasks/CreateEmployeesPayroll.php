<?php

namespace App\Console\Tasks;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

class CreateEmployeesPayroll extends MainClassTasks
{

    public function mainProcess(Schedule $schedule)
    {
        $schedule->call(function (){
            do{
                $temp = $this->createEmployees();
            }while(!$temp);
        })->monthly();
//        })->dailyAt("15:43");
    }

    private function createEmployees(){
        try {
            DB::beginTransaction();
            $employees = $this->getEmployeesIDS();
            foreach ($employees as $employee){
                $salary = Employee::salary($employee);
                Payroll::create([
                    "employee_id" => $employee,
                    "default_salary" => $salary,
                    "total_salary" => $salary,
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
