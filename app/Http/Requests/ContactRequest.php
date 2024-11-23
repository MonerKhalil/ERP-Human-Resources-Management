<?php

namespace App\Http\Requests;

use App\Models\Contact;


class ContactRequest extends BaseRequest
{
    public function rules()
    {
        $callback = (new Contact)->validationRules();

        return $callback($this);

    }
}





