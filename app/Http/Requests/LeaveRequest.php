<?php

namespace App\Http\Requests;

use App\Models\Leave;

class LeaveRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Leave)->validationRules();

        return $callback($this);
    }
}
