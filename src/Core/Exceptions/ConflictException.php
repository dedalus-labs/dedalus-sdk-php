<?php

namespace DedalusSDK\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Conflict Exception';
}
