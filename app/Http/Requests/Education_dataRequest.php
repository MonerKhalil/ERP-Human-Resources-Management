<?php

namespace App\Http\Requests;

use App\Models\Education_data;

class Education_dataRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Education_data)->validationRules();

        return $callback($this);
    }
}
