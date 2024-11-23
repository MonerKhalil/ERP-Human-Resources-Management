<?php

namespace App\Http\Requests;

use App\Models\EmployeeEvaluation;

class EmployeeEvaluationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new EmployeeEvaluation)->validationRules();

        return $callback($this);
    }
}
