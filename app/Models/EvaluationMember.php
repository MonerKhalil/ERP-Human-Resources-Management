<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class EvaluationMember extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","evaluation_id",
        "performance","professionalism","readiness_for_development"
        ,"collaboration","commitment_and_responsibility"
        ,"innovation_and_creativity","technical_skills",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(EmployeeEvaluation::class, 'evaluation_id', 'id');
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "employee_id" => ["sometimes","numeric",Rule::exists("employees","id")],
                "evaluation_id" => ["required",Rule::exists("employee_evaluations","id")],
                "performance" => ["required","integer","min:1","max:10"],
                "professionalism" => ["required","integer","min:1","max:10"],
                "readiness_for_development" => ["required","integer","min:1","max:10"],
                "collaboration" => ["required","integer","min:1","max:10"],
                "commitment_and_responsibility" => ["required","integer","min:1","max:10"],
                "innovation_and_creativity" => ["required","integer","min:1","max:10"],
                "technical_skills" => ["required","integer","min:1","max:10"],
            ];
        };
    }

    public static function typeEvaluation(){
        return [
            "performance","professionalism","readiness_for_development"
            ,"collaboration","commitment_and_responsibility"
            ,"innovation_and_creativity","technical_skills",
        ];
    }
}
