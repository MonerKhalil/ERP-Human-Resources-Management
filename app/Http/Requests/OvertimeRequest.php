<?php

namespace App\Http\Requests;

use App\Models\Overtime;

class OvertimeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Overtime)->validationRules();

        return $callback($this);
    }
}
