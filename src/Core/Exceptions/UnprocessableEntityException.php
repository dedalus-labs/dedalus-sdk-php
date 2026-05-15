<?php

namespace DedalusSDK\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Unprocessable Entity Exception';
}
