<?php

namespace DedalusSDK\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Rate Limit Exception';
}
