<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;

class Education_level extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function education_data(){
        return $this->hasMany(Education_data::class,"id_ed_lev","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "name"=>$validator->textRule(true)
            ];
        };
    }
}
