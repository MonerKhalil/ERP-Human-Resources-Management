<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class EmployeeEvaluation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","evaluation_date",
        "next_evaluation_date",
        "description",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function decisions()
    {
        return $this->hasMany(Decision::class,"evaluation_id","id")
            ->with("session_decision");
    }

    public function enter_evaluation_employee()
    {
        return $this->hasMany(EvaluationMember::class,"evaluation_id","id")
            ->with("employee");
    }

    public function canEvaluation($employee_id){
        $check = !is_null($this->enter_evaluation_employee()->where("employee_id",$employee_id)->first());
        return  (auth()->user()->can("all_employee_evaluations") && $check) || $check;
    }

    public function canShow(){
        $user = auth()->user();
        return $user->can("all_employee_evaluations") || $user->can("read_employee_evaluations")||
            $this->employee_id === ($user->employee->id ?? "");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "evaluation_employees" => ["required","array"],
                "evaluation_employees.*" => ["required","numeric",Rule::exists("employees","id")],
                "employee_id" => ["required","numeric",Rule::exists("employees","id")],
                "evaluation_date" => $validator->dateRules(true),
                "next_evaluation_date" => $validator->afterDateOrNowRules(true,"evaluation_date"),
            ];
        };
    }
}
