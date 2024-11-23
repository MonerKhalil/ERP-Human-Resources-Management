<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use App\Rules\TextRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class SectionExternal extends BaseModel
{
    use HasFactory;

    protected $table = "section_externals";

    protected $fillable = [
        #Add Attributes
        "name","address_id","address_details",
        "email","fax","phone",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id", "id")
            ->with("country");
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $section = is_null($validator->route("section_external")) ? "" : $validator->route("section_external")->id;
            return [
                "name" => ["required",new TextRule(),"max:255",
                    !$validator->isUpdatedRequest() ? Rule::unique("section_externals","name")
                        : Rule::unique("section_externals","name")->ignore($section)],
                "address_id" => ["required", Rule::exists('addresses', 'id')],
                "address_details" => $validator->textRule(true),
                "email"=>["email","required"],
                "fax"=>["integer","required"],
                "phone"=>["integer","required"],
            ];
        };
    }
}
