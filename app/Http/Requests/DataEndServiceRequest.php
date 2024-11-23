<?php

namespace App\Http\Requests;

use App\Models\DataEndService;

class DataEndServiceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new DataEndService)->validationRules();

        return $callback($this);
    }
}
