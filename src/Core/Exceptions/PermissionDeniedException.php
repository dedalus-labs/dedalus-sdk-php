<?php

namespace DedalusSDK\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'DedalusSDK Permission Denied Exception';
}
