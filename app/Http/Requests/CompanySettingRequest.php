<?php

namespace App\Http\Requests;

use App\Models\CompanySetting;

class CompanySettingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new CompanySetting)->validationRules();

        return $callback($this);
    }
}
