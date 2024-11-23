<?php

namespace App\Http\Requests;

use App\Models\Employee;

class EmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Employee)->validationRules();

        return $callback($this);

    }
}
