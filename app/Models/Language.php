<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;

class Language extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "name",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function language_skill(){

        return $this->hasMany(Language_skill::class,'language_id','id');
    }
    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "name" => $validator->textRule(true)
            ];
        };
    }
}
