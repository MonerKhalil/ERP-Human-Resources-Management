<?php

namespace App\Http\Requests;

use App\Models\EvaluationMember;
use Illuminate\Validation\Rule;

class EvaluationMemberRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new EvaluationMember)->validationRules();

        return $callback($this);
    }
}
