<?php

namespace App\Http\Requests;

use App\Models\Decision;
use Illuminate\Validation\Rule;

class DecisionEvaluationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "evaluation_id" => ["required",Rule::exists("employee_evaluations","id")],
            "moderator_id" => ["required", Rule::exists("employees","id")],
            "name" => $this->textRule(true,null,3,255),
            "date_session" => $this->dateRules(true),
            "description" => ["nullable","string"],
            "image" => $this->imageRule(false),
            "file" => $this->fileRules(false),
            //Decision
            "number" => ["required", "integer",Rule::unique("decisions","number")],
            "effect_salary" => ["required", Rule::in(Decision::effectSalary())],
            "date" => $this->dateRules(true),
            "content" => ["nullable","string"],
            "end_date_decision" => $this->afterDateOrNowRules(false,'date'),
            "value" => [Rule::requiredIf(function (){
                return isset($this->effect_salary) &&
                    ($this->effect_salary=="increment" || $this->effect_salary=="decrement");
            }),Rule::when(isset($this->effect_salary) &&
                ($this->effect_salary=="none"),"nullable"),"numeric","min:1"],
            "rate" => [Rule::requiredIf(function (){
                return isset($this->effect_salary) &&
                    ($this->effect_salary=="increment" || $this->effect_salary=="decrement");
            }),Rule::when(isset($this->effect_salary) &&
                ($this->effect_salary=="none"),"nullable"),"numeric","min:1","max:100"],
            "image_decision" => $this->imageRule(false),
        ];
    }
}
