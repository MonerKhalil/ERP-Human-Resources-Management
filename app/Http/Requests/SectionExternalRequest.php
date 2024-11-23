<?php

namespace App\Http\Requests;

use App\Models\SectionExternal;

class SectionExternalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new SectionExternal)->validationRules();

        return $callback($this);
    }
}
