<?php

namespace App\Http\Requests;

use App\Models\Country;

class CountryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new Country)->validationRules();

        return $callback($this);
    }
}
