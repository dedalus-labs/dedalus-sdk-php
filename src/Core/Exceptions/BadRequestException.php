<?php

namespace DedalusSDK\Core\Exceptions;

class BadRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Bad Request Exception';
}
