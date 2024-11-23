<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id" ,"total_salary","default_salary",
        "overtime_minute","overtime_value","bonuses_decision","penalties_decision",
        "absence_days","absence_days_value",
        "count_leaves_unpaid","leaves_unpaid_value","count_leaves_effect_salary","leaves_effect_salary_value",
        "position_employee_value","conferences_employee_value",
        "education_value",
        "minutes_late_entry","minutes_late_entry_value",
        "minutes_early_exit","minutes_early_exit_value",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function employee(){
        return $this->belongsTo(Employee::class,"employee_id","id");
    }
    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                //Rules
            ];
        };
    }
}
