<?php

namespace App\Exceptions;
use Exception;

class NotAllowedException extends Exception {



    public function render()
    {
        return response()->json(
            [
                'message' => 'Only Temper admins are allowed to visit this page.'
            ]
        );
    }

}
