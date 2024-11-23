<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Decision extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "evaluation_id",
        "type_decision_id","session_decision_id","number","date","content",
        "effect_salary","end_date_decision","value","image","rate",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function type_decision(){
        return $this->belongsTo(TypeDecision::class,"type_decision_id","id");
    }

    public function session_decision(){
        return $this->belongsTo(SessionDecision::class,"session_decision_id","id");
    }

    public function evaluation(){
        return $this->belongsTo(EmployeeEvaluation::class,"evaluation_id","id");
    }

    public function employees(){
        return $this->belongsToMany(Employee::class,"employee_decisions",
            "decision_id",
            "employee_id",
            "id",
            "id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $rule = !$validator->isUpdatedRequest() ? "required" : "sometimes";
            $rules = [
                "type_decision_id" => [$rule, Rule::exists("type_decisions","id")],
                "session_decision_id" => [$rule, Rule::exists("session_decisions","id")],
                "employees" => ["sometimes","array"],
                "employees.*" => [Rule::exists("employees","id")],
                "number" => [$rule, "numeric",Rule::unique("decisions","number")],
                "effect_salary" => [$rule, Rule::in(self::effectSalary())],
                "date" => $validator->dateRules(true),
                "content" => [$rule,"string"],
                "end_date_decision" => $validator->afterDateOrNowRules(false,'date'),
                "rate" => [Rule::requiredIf(function ()use($validator){
                    return isset($validator->effect_salary) &&
                        ($validator->effect_salary=="increment" || $validator->effect_salary=="decrement");
                }),Rule::when(isset($validator->effect_salary) &&
                    ($validator->effect_salary=="none"),"nullable"),"numeric","min:1","max:100"],
                "image" => $validator->imageRule(false),
            ];
            if ($validator->isUpdatedRequest()){
                $rules['number'] =  [$rule,Rule::unique("decisions","number")->ignore($validator->route('decision')->id??"")];
            }
            return $rules;
        };
    }

    public static function effectSalary(){
        return ["increment","decrement","none"];
    }
}
