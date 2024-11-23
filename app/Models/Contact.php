<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Contact extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "address_id","employee_id","work_number","address_details",
        "private_number1","private_number2","address_type","email",
        "created_by","updated_by","is_active",
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id", "id")
            ->with("country");
    }

    public function document_contact()
    {
        return $this->hasMany(DocumentContact::class,"contact_id","id");
    }

    public function canEdit(){
        $employee = $this->employee()->user->id ?? null;
        if(!is_null($employee)){
            return $employee == auth()->id()
                ||
                auth()->user()->can("update_employees")
                ||
                auth()->user()->can("all_employees");
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
            $employee = is_null($validator->route("employee")) ? "" : $validator->route("employee")->id;
            $rule = $validator->isUpdatedRequest() ? "sometimes" : "required";
            return [
                "address_id" => [$rule, Rule::exists('addresses', 'id')],
                "work_number"=> [$rule ,
                    !$validator->isUpdatedRequest() ?  Rule::unique('contacts', 'work_number')
                        : Rule::unique('contacts', 'work_number')->ignore($employee,"employee_id")],
                "address_details" => $validator->textRule(false,true),
                "private_number1"=>[$rule,"numeric"],
                "private_number2"=>[$rule, "numeric"],
                "email" => [$rule, 'string', 'email'],
                "address_type"=>[$rule, Rule::in(["house","clinic","office"])],
            ];
        };
    }
}
