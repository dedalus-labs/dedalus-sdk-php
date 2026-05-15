<?php

namespace DedalusSDK\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Not Found Exception';
}
