<?php

namespace App\Http\Requests;

use App\Models\LeaveType;

class LeaveTypeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new LeaveType)->validationRules();

        return $callback($this);
    }
}
