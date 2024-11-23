<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Membership extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "member_type_id", "number_membership", "branch", "date_start", "date_end","employee_id",
        "created_by", "updated_by", "is_active",
    ];

    // Add relationships between tables section
    public function membership_type()
    {
        return $this->belongsTo(Membership_type::class, "member_type_id", "id");
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, "employee_id", "id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules()
    {
        return function (BaseRequest $validator) {
            $memberID = $validator->route('membership') ?? 0;
            return [
                "member_type_id"=> [ 'required', Rule::exists('membership_types', 'id')],
                "number_membership" => ['required', 'numeric', 'min:0', 'max:100000'
                    , Rule::unique('memberships', 'number_membership',)->ignore($memberID)],
                "branch" => $validator->textRule(),
                "date_start" => ['required', 'date'],
                "date_end" => ['required', 'date'],
                "employee_id" => ['required', Rule::exists('employees', 'id')],
            ];
        };
    }
}
