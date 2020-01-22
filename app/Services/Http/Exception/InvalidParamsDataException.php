<?php
/**
 * Created by PhpStorm.
 * User: milhous
 * Date: 12.06.16
 * Time: 20:26
 */

namespace App\Services\Http\Exception;

class InvalidParamsDataException extends HttpClientException
{
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
        return parent::__construct('Invalid Params');
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
