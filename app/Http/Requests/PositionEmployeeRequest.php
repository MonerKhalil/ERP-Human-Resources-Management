<?php

namespace App\Http\Requests;

use App\Models\PositionEmployee;

class PositionEmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new PositionEmployee)->validationRules();

        return $callback($this);
    }
}
