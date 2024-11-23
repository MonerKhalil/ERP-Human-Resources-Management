<?php

namespace App\Models;

use App\Http\Requests\BaseRequest;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Description: To check front end validation
     * @inheritDoc
     */
    public function validationRules(){
        return function (BaseRequest $validator) {
            return [
                //Rules
            ];
        };
    }
}
