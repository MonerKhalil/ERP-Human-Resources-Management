<?php

namespace App\Http\Requests;

use App\Models\SessionDecision;

class SessionDecisionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new SessionDecision)->validationRules();

        return $callback($this);
    }
}
