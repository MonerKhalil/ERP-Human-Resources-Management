<?php

namespace App\Http\Requests;

use App\Models\PublicHoliday;

class PublicHolidayRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $callback = (new PublicHoliday)->validationRules();

        return $callback($this);
    }
}
