<?php

namespace App\Exceptions;
use Exception;

class NotLoginException extends Exception {

    public function render()
    {
        return response()->json(
            [
                'message' => 'You need to login.'
            ]
        );
    }

}
