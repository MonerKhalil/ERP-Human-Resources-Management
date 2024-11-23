<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class SessionDecision extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "moderator_id","name","date_session","file","image","description",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function moderator(){
        return $this->belongsTo(Employee::class,"moderator_id","id");
    }

    public function members(){
        return $this->belongsToMany(Employee::class,"member_session_decisions",
        "session_decision_id",
        "employee_id",
        "id",
        "id");
    }

    public function decisions(){
        return $this->hasMany(Decision::class,"session_decision_id","id");
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
                "moderator_id" => [$rule, Rule::exists("employees","id")],
                "name" => $validator->textRule($rule === "required",null,3,255),
                "date_session" => $validator->dateRules($rule === "required"),
                "description" => $validator->textRule(false,true),
                "image" => $validator->imageRule(false),
                "file" => $validator->fileRules(false),
                "members" => [$rule,"array"],
                "members.*" => ["numeric",Rule::exists("employees","id")],
            ];
        };
    }
}
