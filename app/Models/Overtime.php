<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Overtime extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","overtime_type_id"
        ,"from_date","to_date","count_days"
        ,"from_time","to_time","count_hours_in_days","is_hourly",
        "description","status","reject_details","date_update_status",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function overtime_type(){
        return $this->belongsTo(OvertimeType::class,"overtime_type_id","id");
    }

    public function employee(){
        return $this->belongsTo(Employee::class,"employee_id","id");
    }

    public function canDelete(){
        $user = auth()->user();
        if ($user->can("all_overtimes") || $user->can("delete_overtimes")){
            return true;
        }
        if (($user->employee->id == $this->employee_id) && $this->status == "pending"){
            return true;
        }
        return false;
    }

    public function canEdit(){
        $user = auth()->user();
        if ($user->can("all_overtimes") || $user->can("update_overtimes")){
            return true;
        }
        if (($user->employee->id == $this->employee_id) && $this->status == "pending"){
            return true;
        }
        return false;
    }

    public function canShow(){
        $user = auth()->user();
        if ($user->can("all_overtimes") || $user->can("read_overtimes")){
            return true;
        }
        if ($user->employee->id == $this->employee_id){
            return true;
        }
        return false;
    }


    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "overtime_type_id" => ["required",Rule::exists("overtime_types","id")],
                "description" => ["nullable","string"],
                "from_date" => $validator->dateRules(true),
                "to_date" => $validator->afterDateOrNowRules(true,"from_date"),
                "is_hourly" => ["required","boolean"],
                "from_time" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("is_hourly") == "true" || $validator->input("is_hourly") == 1;
                }),"date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "to_time" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("is_hourly") == "true" || $validator->input("is_hourly") == 1;
                }),"after:from_time","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"]
            ];
        };
    }
}
