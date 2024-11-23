<?php

namespace App\Http\Requests;

use App\Models\Correspondence_source_dest;

class LegelRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new  Correspondence_source_dest )->validationRules();

        return $callback($this);
    }
}
