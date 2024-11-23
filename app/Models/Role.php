<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes;
    /**
     * Description: To check front end validation
     * @inheritDoc
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            $rules = [
                'name' => ['required',Rule::unique("roles","name")],
                'permissions' => 'required|array',
                'permissions.*' => ['required',Rule::exists("permissions","id")],
            ];
            if ($validator->isUpdatedRequest()){
                $rules['name'] =  ["required",Rule::unique("roles","name")->ignore($validator->route('role')->id)];
            }
            return $rules;
        };
    }
}
