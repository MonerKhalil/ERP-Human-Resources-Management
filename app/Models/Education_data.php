<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Education_data extends BaseModel
{
    use HasFactory;
    protected $table = "education_data";
    protected $fillable = [
        #Add Attributes
        "employee_id","id_ed_lev","grant_date",
        "college_name","amount_impact_salary",
        "is_active","created_by","updated_by",
    ];

    // Add relationships between tables section
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function education_level()
    {
        return $this->belongsTo(Education_level::class,"id_ed_lev","id");
    }

    public function document_education()
    {
        return $this->hasMany(Document_education::class,"id_education","id");
    }

    public function canEdit(){
        $employee = $this->employee()->user->id ?? null;
        if(!is_null($employee)){
            return $employee == auth()->id()
                ||
                auth()->user()->can("update_employees")
                ||
                auth()->user()->can("all_employees");
        }
        return false;
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $rule = $validator->isUpdatedRequest() ? "sometimes" : "required";
            return [
                "id_ed_lev"=>[$rule, Rule::exists('education_levels', 'id')],
                "grant_date"=> $validator->dateRules($rule==="required"),
                "college_name"=>$validator->textRule($rule==="required"),
                "amount_impact_salary"=>['integer', 'min:1', 'max:100'],
            ];
        };
    }
}
