<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Position extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name","rate_salary","rate_stimulus",//حوافز
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function employees(){
        return $this->belongsToMany(Employee::class,"position_employees"
            ,"position_id"
            ,"employee_id"
            ,"id"
            ,"id");
    }

    public function position_employees(){
        return $this->hasMany(PositionEmployee::class,"position_id","id")
            ->with(["position","employee","decision","section"]);
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $current = $validator->route("position")->id ?? "";
            return [
                "name" => !$validator->isUpdatedRequest() ? [
                    "required",new TextRule(),"string","min:1","max:255",Rule::unique("positions"),
                ] : [
                    "sometimes",new TextRule(),"string","min:1","max:255",Rule::unique("positions","name")->ignore($current),
                ],
                "rate_salary" => ["required","numeric","min:1","max:100"],
                "rate_stimulus" => ["required","numeric","min:1","max:100"],
            ];
        };
    }
}
