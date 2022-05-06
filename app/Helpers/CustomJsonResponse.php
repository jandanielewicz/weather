<?php

namespace App\Helpers;

use App\Settings;
use Illuminate\Support\Facades\Cache;

class CustomJsonResponse
{
    public static function error($code = 400, $message = null)
    {
        // check if $message is object and transforms it into an array
        if (is_object($message)) {
            $message = $message->toArray();
        }

        switch ($code) {
            default:
                $code_message = 'error_occured';
                break;
        }

        $data = array(
            'code' => $code,
            'message' => $code_message,
            'data' => $message
        );

        // return an error
        return \Illuminate\Http\Response::json($data, $code);
    }
}
