<?php

namespace App\Http\Requests;

use App\Models\Membership;

class MembershipRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Membership)->validationRules();

        return $callback($this);
    }
}
