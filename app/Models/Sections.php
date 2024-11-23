<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Sections extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "moderator_id","address_id" ,"name","details",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function moderator(){
        return $this->belongsTo(Employee::class,"moderator_id","id")->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id", "id")
            ->with("country");
    }

    public function contracts(){
        return $this->hasMany(Contract::class,"section_id","id");
    }

    public function employees(){
        return $this->hasMany(Employee::class,"section_id","id");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $section = is_null($validator->route("section")) ? "" : $validator->route("section")->id;
            return [
                "name" => ["required",new TextRule(),"max:255",
                    !$validator->isUpdatedRequest() ? Rule::unique("sections","name")
                        : Rule::unique("sections","name")->ignore($section)],
                "address_id" => ["required", Rule::exists('addresses', 'id')],
                "moderator_id" => ["nullable","numeric",Rule::exists("employees","id")],
                "details" => ["nullable","string"],
            ];
        };
    }
}
