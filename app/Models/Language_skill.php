<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Language_skill extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        #Add Attributes
        "employee_id","read","write","language_id",
        "created_by","updated_by","is_active",
    ];

    // Add relationships between tables section
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id')
            ->withDefault();
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id')
            ->withDefault();
    }
    /**
     * Description: To check front end validation
     * @inheritDoc
     * @author moner khalil
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                "employee_id"=> ['required', Rule::exists('employees', 'id')],
                "language_id"=>['required', Rule::exists('languages', 'id')],
                "read"=>['required',Rule::in(["Beginner","Intermediate","Advanced"])],
                "write"=>['required',Rule::in(["Beginner","Intermediate","Advanced"])],
            ];
        };
    }
}
