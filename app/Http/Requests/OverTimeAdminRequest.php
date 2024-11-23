<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class OverTimeAdminRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "overtime_type_id" => ["required",Rule::exists("overtime_types","id")],
            "description" => ["nullable","string"],
            "from_date" => $this->dateRules(true),
            "to_date" => $this->afterDateOrNowRules(true,"from_date"),
            "is_hourly" => ["required","boolean"],
            "from_time" => [Rule::requiredIf(function (){
                return $this->input("is_hourly") == "true" || $this->input("is_hourly") == 1;
            }),"date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
            "to_time" => [Rule::requiredIf(function (){
                return $this->input("is_hourly") == "true" || $this->input("is_hourly") == 1;
            }),"after:from_time","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"]
        ];
        if (!$this->isUpdatedRequest()) {
            $rules["employee_id"] = ["required",Rule::exists("employees","id")];
        }
        return $rules;
    }
}
