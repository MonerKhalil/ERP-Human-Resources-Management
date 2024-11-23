<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class DataEndService extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","decision_id","reason","reason_other","description",
        "start_break_date","end_break_date","is_request_end_services",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function employee(){
        return $this->belongsTo(Employee::class,"employee_id","id")->with("section");
    }

    public function decision(){
        return $this->belongsTo(Decision::class,"decision_id","id");
    }


    public function canShow(){
        $employee = $this->employee()->user->id ?? null;
        if(!is_null($employee)){
            return $employee == auth()->id()
                ||
                auth()->user()->can("read_request_end_services")
                ||
                auth()->user()->can("all_request_end_services");
        }
        return false;
    }
    /**
     * @return string[]
     */
    public static function Reasons(){
        return ["disintegration","resignation","military_service","leaving_work","other"];
    }
    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "employee_id" => ["required",Rule::exists("employees","id")],
                "decision_id" => ["required",Rule::exists("decisions","id")],
                "reason" => ["required"],
//                Rule::in(self::Reasons())
                "reason_other" => ["string","max:255",new TextRule(),Rule::requiredIf(function ()use($validator){
                    return $validator->reason === "other";
                })],
                "start_break_date" => $validator->dateRules(true),
                "end_break_date" => $validator->afterDateOrNowRules(true,"start_break_date"),
                "description" => ["nullable","string"],
            ];
        };
    }
}
