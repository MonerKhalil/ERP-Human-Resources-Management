<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class OvertimeType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name","max_rate_salary","min_hours_in_days","salary_in_hours",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function overtimes(){
        return $this->hasMany(Overtime::class,"overtime_type_id","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $current = $validator->route("overtime_type")->id ?? "";
            return [
                "name" => !$validator->isUpdatedRequest() ? [
                    "required",new TextRule(),"string","min:1","max:255",Rule::unique("overtime_types"),
                ] : [
                    "sometimes",new TextRule(),"string","min:1","max:255",Rule::unique("overtime_types","name")->ignore($current),
                ],
                "max_rate_salary" => ["nullable","numeric","min:1","max:100"],
                "min_hours_in_days" => ["nullable","numeric","min:1","max:24"],
                "salary_in_hours" => ["required","numeric","min:1"],
            ];
        };
    }
}
