<?php

namespace App\Http\Requests;

use App\Models\Contract;

class ContractRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Contract())->validationRules();

        return $callback($this);
    }
}
