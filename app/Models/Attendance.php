<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","check_in","check_out",
        "hours_work","hours_work_per_minute",
        "late_entry_per_minute","early_exit_per_minute",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id')->with("section");
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
