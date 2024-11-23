<?php

namespace App\Http\Requests;

use App\Models\Conference;

class ConferenceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Conference)->validationRules();

        return $callback($this);
    }
}
