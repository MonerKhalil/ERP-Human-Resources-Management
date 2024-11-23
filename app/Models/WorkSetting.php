<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class WorkSetting extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name","count_days_work_in_weeks","count_hours_work_in_days",
        "days_leaves_in_weeks",
        "work_hours_from","work_hours_to","description",
        "late_enter_allowance_per_minute","early_out_allowance_per_minute",
        "salary_default","rate_deduction_from_salary","type_discount_minuteOrHour",
        "rate_deduction_attendance_dont_check_out",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $work_setting = is_null($validator->route("work_setting")) ? "" : $validator->route("work_setting")->id;
            return [
                "name" => ["required",new TextRule(),"max:255",
                    !$validator->isUpdatedRequest() ? Rule::unique("work_settings","name")
                        : Rule::unique("work_settings","name")->ignore($work_setting)],
                //daysLeavesOnly
                "days" => ["nullable","array"],
                "days.*" => [Rule::requiredIf(function ()use($validator){
                    return !is_null($validator->input("days"));
                }),Rule::in(Days())],
                "work_hours_from" => ["required","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "work_hours_to" => ["required","after:work_hours_from","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "description" => ["nullable","string"],
                "late_enter_allowance_per_minute" => ["required","integer",],
                "early_out_allowance_per_minute" => ["required","integer",],
                "salary_default" => ["required","numeric"],
                "rate_deduction_from_salary" => ["required","integer","min:1","max:100"],
                "type_discount_minuteOrHour" => ["required",Rule::in(["minute","hour"])],
                "rate_deduction_attendance_dont_check_out" =>["required","integer","min:1","max:100"],
            ];
        };
    }
}
