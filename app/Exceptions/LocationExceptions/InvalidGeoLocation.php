<?php

namespace App\Exceptions\LocationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class InvalidGeoLocation extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = 'Invalid GeoLocation';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
