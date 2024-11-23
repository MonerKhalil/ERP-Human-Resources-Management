<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class CompanySetting extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name","created_at_company",
        "count_administrative_leaves","count_years_services_employees",
        "add_leaves_years_services_employees",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "name" => $validator->textRule(true),
                "created_at_company" => ["required","date"],
                "add_leaves_years_services_employees" => ["nullable","numeric","min:0"],
            ];
        };
    }
}
