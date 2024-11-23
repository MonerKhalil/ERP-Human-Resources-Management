<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class DocumentContact extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "contact_id","document_type","document_number",
        "document_path",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function contact(){
        return $this->belongsTo(Contact::class,"contact_id","id" );
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            if ($validator->isUpdatedRequest()){
                $rules = [
                    "document_type" => ["sometimes",Rule::in(["family_card","identification","passport"])],
                    "document_number" => ['sometimes','numeric','min:1'],
                    "document_path" => $validator->fileRules(true),
                ];
            }else{
                $rules = [
                    "document_contact" => ["required","array"],
                    "document_contact.*" => ["required","array"],
                    "document_contact.*.document_type" => ['required', Rule::in(["family_card","identification","passport"])],
                    "document_contact.*.document_number" => ['required','numeric','min:1'],
                    "document_contact.*.document_path" => $validator->fileRules(true),
                ];
            }
            return $rules;
        };
    }
}
