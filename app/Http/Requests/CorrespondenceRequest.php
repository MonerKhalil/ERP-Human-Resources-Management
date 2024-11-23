<?php

namespace App\Http\Requests;

use App\Models\Correspondence;

class CorrespondenceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Correspondence)->validationRules();

        return $callback($this);
    }
}
