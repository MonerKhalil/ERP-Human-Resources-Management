<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Carbon;

class YearsEmployeeService
{
    public function updateServicesYearsEmployee($employee_id){
        $employee = Employee::query()->find($employee_id);
        $allContracts = $employee->contract;
        $allMonths = 0;
        foreach ($allContracts as $item){
            $direct_date = Carbon::parse($item->contract_direct_date)->format("Y-m-d");
            $finish = Carbon::parse($item->contract_finish_date)->format("Y-m-d");
            $allMonths += Carbon::createFromFormat("Y-m-d",$finish)->diffInMonths($direct_date);
        }
        $employee->update([
            "count_month_services" => $allMonths,
        ]);
    }
}
