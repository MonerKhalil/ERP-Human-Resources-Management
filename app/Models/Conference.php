<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Conference extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "address_id","name","start_date","end_date","rate_effect_salary","type",
        "address_details","name_party",
        "created_by","updated_by","is_active",
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id", "id")
            ->with("country");
    }

    public function employees(){
        return $this->belongsToMany(Employee::class,"conference_employees"
        ,"conference_id"
        ,"employee_id"
        ,"id"
        ,"id");
    }

    // Add relationships between tables section

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $rule = $validator->isUpdatedRequest() ? "sometimes" : "required";
            return [
                "name" => $validator->textRule(true),
                "type" => ["required",Rule::in(["course","conference"])],
                "name_party" => $validator->textRule(true),
                "address_id" => ["required", Rule::exists('addresses', 'id')],
                "address_details" => $validator->textRule(false),
                "rate_effect_salary" => ["required","numeric","min:1","max:100"],
                "start_date" => $validator->dateRules(true),
                "end_date" => $validator->afterDateOrNowRules(true,"start_date"),
                "employees" => ["required","array"],
                "employees.*" => ["numeric",Rule::exists("employees","id")],
            ];
        };
    }
}
