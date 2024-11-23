<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Leave extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","leave_type_id"
        ,"from_date","to_date", "from_time","to_time",
        "count_days", "minutes",
        "description","status","reject_details","date_update_status",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function leave_type(){
        return $this->belongsTo(LeaveType::class,"leave_type_id","id");
    }

    public function employee(){
        return $this->belongsTo(Employee::class,"employee_id","id");
    }

    public function canDelete(){
        $user = auth()->user();
        if ($user->can("all_leaves") || $user->can("delete_leaves")){
            return true;
        }
        if (($user->employee->id == $this->employee_id) && $this->status == "pending"){
            return true;
        }
        return false;
    }

    public function canEdit(){
        $user = auth()->user();
        if ($user->can("all_leaves") || $user->can("update_leaves")) {
            return true;
        }
        if (($user->employee->id == $this->employee_id) && $this->status == "pending"){
            return true;
        }
        return false;
    }

    public function canShow(){
        $user = auth()->user();
        if ($user->can("all_leaves") || $user->can("read_leaves")){
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
            $leaveType = LeaveType::query()->find($validator->input("leave_type_id"));
            $is_hourly = $leaveType->is_hourly ?? null;
            $can_hours = $leaveType->can_take_hours ?? null;
            return [
                "leave_type_id" => ["required",Rule::exists("leave_types","id")],
                "from_hour" => [Rule::requiredIf(function ()use($is_hourly){
                    return $is_hourly;
                }),"date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "to_hour" => [Rule::requiredIf(function ()use($validator){
                    return !is_null($validator->input("from_hour"));
                }),"after:from_hour","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "description" => ["nullable","string"],
                "from_date" => $validator->dateRules(true),
                "to_date" => $validator->afterDateOrNowRules(true,"from_date"),
                "can_from_hour" => ["nullable","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
                "can_to_hour" => [Rule::requiredIf(function ()use($validator,$can_hours){
                    return !is_null($validator->input("can_from_hour")) && $can_hours;
                }),"after:can_from_hour","date_format:g:i:s,g:i,g:i:s A,g:i A,H:i:s,H:i,H:i:s A,H:i A"],
            ];
        };
    }

    public static function status(){
        return ["pending","approve","reject"];
    }
}
