<?php

namespace App\Http\Requests;

use App\Models\Attendance;

class AttendanceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Attendance)->validationRules();

        return $callback($this);
    }
}