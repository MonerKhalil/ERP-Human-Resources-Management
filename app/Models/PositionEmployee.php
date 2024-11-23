<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class PositionEmployee extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "position_id","employee_id","decision_id"
        ,"start_date","end_date","notes",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function position(){
        return $this->belongsTo(Position::class,"position_id","id")->withTrashed();
    }

    public function employee(){
        return $this->belongsTo(Employee::class,"employee_id","id")->with(["section"]);
    }

    public function decision(){
        return $this->belongsTo(Decision::class,"decision_id","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "decision_id" => ["required",Rule::exists("decisions")],
                "employee_id" => ["required",Rule::exists("employees")],
                "position_id" => ["required",Rule::exists("position_id")],
                "start_date" => $validator->dateRules(true),
                "end_date" => $validator->afterDateOrNowRules(true,"start_date"),
                "notes" => $validator->textRule(true,null,1,500),
            ];
        };
    }
}
