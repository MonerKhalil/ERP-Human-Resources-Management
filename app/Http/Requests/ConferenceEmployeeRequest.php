<?php

namespace App\Http\Requests;

use App\Models\ConferenceEmployee;

class ConferenceEmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new ConferenceEmployee)->validationRules();

        return $callback($this);
    }
}
