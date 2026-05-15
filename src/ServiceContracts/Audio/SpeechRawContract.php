<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Audio;

use DedalusSDK\Audio\Speech\SpeechCreateParams;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface SpeechRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SpeechCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function create(
        array|SpeechCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
