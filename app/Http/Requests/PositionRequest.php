<?php

namespace App\Http\Requests;

use App\Models\Position;

class PositionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Position)->validationRules();

        return $callback($this);
    }
}
