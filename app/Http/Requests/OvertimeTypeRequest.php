<?php

namespace App\Http\Requests;

use App\Models\OvertimeType;

class OvertimeTypeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new OvertimeType)->validationRules();

        return $callback($this);
    }
}
