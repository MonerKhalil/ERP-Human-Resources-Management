<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConferenceEmployee extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "conference_id","employee_id",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function conference(){
        return $this->belongsTo(Conference::class,"conference_id","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                //Rules
            ];
        };
    }
}
