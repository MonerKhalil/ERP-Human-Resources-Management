<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Correspondence_source_dest extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "correspondences_id", //
        'source_correspondence_id',
        "current_employee_id", //
        "external_party_id", //
        "internal_department_id", //
        "is_done",
        "type","notice","path_file",
         "source_dest_type",
        //////legal section
        "legal_opinion","path_file_legal_opinion","is_legal",
        /////////////
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function employee_current()
    {
        return $this->belongsTo(Employee::class, 'current_employee_id', 'id');
    }

    public function external_party()
    {
        return $this->belongsTo(SectionExternal::class, 'external_party_id', 'id');
    }
    public function internal_department()
    {
        return $this->belongsTo(Sections::class, 'internal_department_id', 'id');
    }
    public function correspondence()
    {
        return $this->belongsTo(Correspondence::class, 'correspondences_id', 'id');
    }

    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
//            dd($validator->source_correspondence_id);
            return [
                "type" => ["required", Rule::in(Correspondence::type())],
                "source_correspondence_id" => ["nullable", Rule::exists("correspondences","id")],
                "correspondences_id"=>["required",Rule::exists("correspondences","id")],
                "source_dest_type" => ["required",Rule::in(self::source_dest_type())],
                "is_done"=>["nullable","boolean",],
                "external_party_id" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("type") == "external";///check
                }),Rule::exists("section_externals","id")],
                "internal_department_id" => [Rule::requiredIf(function ()use($validator){
                    return $validator->input("type") == "internal";
                }),Rule::exists("sections","id")],
                "notice"=>$validator->textRule(false),
                "path_file" =>$validator->fileRules(false),
                //////legal section
                "legal_opinion" => $validator->textRule(false),
                "path_file_legal_opinion" => $validator->fileRules(false),
                "is_legal" => ["nullable",Rule::in(["legal","illegal"]) ],
            ];
        };
    }
    public static function source_dest_type(){
        return ['outgoing','incoming','outgoing_to_incoming','incoming_to_outgoing'];
    }
}
