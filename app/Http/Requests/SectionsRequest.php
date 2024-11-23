<?php

namespace App\Http\Requests;

use App\Models\Sections;

class SectionsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Sections)->validationRules();

        return $callback($this);
    }
}
