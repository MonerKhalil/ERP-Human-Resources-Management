<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class LeaveType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name","type_effect_salary","rate_effect_salary","gender",
        "max_days_per_years","years_employee_services",
        "leave_limited","can_take_hours",
        "is_hourly","max_hours_per_day",
        "number_years_services_increment_days","count_days_increment_days",
        "count_available_in_service",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function employees(){
        return $this->belongsToMany(Employee::class,"leaves"
            ,"leave_type_id"
            ,"employee_id"
            ,"id"
            ,"id");
    }

    public function leaves(){
        return $this->hasMany(Leave::class,"leave_type_id","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $current = $validator->route("leave_type")->id ?? "";
            return [
                "name" => !$validator->isUpdatedRequest() ? [
                    "required",new TextRule(),"string","min:1","max:255",Rule::unique("leave_types"),
                ] : [
                    "sometimes",new TextRule(),"string","min:1","max:255",Rule::unique("leave_types","name")->ignore($current),
                ],
                "type_effect_salary" => ["required",Rule::in(self::type_effect_salary())],
                "rate_effect_salary" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("type_effect_salary")=="effect_salary";
                }),"numeric","min:1","max:100"],
                "gender" => ["required",Rule::in(self::gender())],
                "is_hourly" => [Rule::requiredIf(function () use($validator){
                    return ($validator->input("leave_limited") == "true" || $validator->input("leave_limited") == 1);
                }),"boolean"],
                "max_hours_per_day" => [Rule::requiredIf(function ()use($validator){
                    return ($validator->input("is_hourly") == "true" || $validator->input("is_hourly") == 1)
                        &&
                        ($validator->input("leave_limited") == "false" || $validator->input("leave_limited") == 0);
                }),"numeric"],
                "leave_limited" => ["required","boolean"],
                "can_take_hours" => ["sometimes","boolean"],
                "max_days_per_years" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("leave_limited") == "true" || $validator->input("leave_limited") == 1;
                }),"numeric","min:1"],
                "years_employee_services" => ["required","numeric","min:0"],
                "number_years_services_increment_days" => ["nullable","numeric","min:1"],
                "count_days_increment_days" => [Rule::requiredIf(function () use($validator){
                    return $validator->input("number_years_services_increment_days") !== null;
                }),"numeric","min:1"],
                "count_available_in_service" => ["nullable","numeric","min:1"],
            ];
        };
    }

    public static function type_effect_salary(){
        return  ["unpaid","paid","effect_salary"];
    }

    public static function gender(){
        return ["male","female","any"];
    }
}
