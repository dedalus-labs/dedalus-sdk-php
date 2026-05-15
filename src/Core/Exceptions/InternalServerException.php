<?php

namespace DedalusSDK\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Internal Server Exception';
}
