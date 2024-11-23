<?php

namespace App\Exceptions;

use App\HelpersClasses\MessagesFlash;
use Exception;
use Illuminate\Http\RedirectResponse;

class MainException extends Exception
{
    protected $code = 400;

    public function render(): RedirectResponse
    {
        MessagesFlash::Errors($this->getMessage());
        return redirect()->back();
    }
}
