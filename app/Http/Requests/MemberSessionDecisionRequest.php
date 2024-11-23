<?php

namespace App\Http\Requests;

use App\Models\MemberSessionDecision;

class MemberSessionDecisionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new MemberSessionDecision)->validationRules();

        return $callback($this);
    }
}
