<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Document_education extends BaseModel
{
    use HasFactory;

    protected $table = "document_educations";
    protected $fillable = [
        #Add Attributes
        "document_education_path", "id_education",
        "created_by", "updated_by"
    ];

    // Add relationships between tables section
    public function document_education()
    {
        $this->belongsTo(Education_data::class,"id_education","id");
    }
    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules()
    {
        return function (BaseRequest $validator) {
            if ($validator->isUpdatedRequest()){
                return [
                    "document_education_path" => $validator->fileRules(true),
                ];
            }else{
                return [
                    "document_education_path" =>['required','array'],
                    "document_education_path.*" => $validator->fileRules(true),
                ];
            }
        };
    }
}
