<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;
use DedalusSDK\Responses\Response;
use DedalusSDK\Responses\ResponseCreateParams1 as ResponseCreateParams;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface ResponsesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ResponseCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Response>
     *
     * @throws APIException
     */
    public function create(
        array|ResponseCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
