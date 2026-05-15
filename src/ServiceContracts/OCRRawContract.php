<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\OCR\OCRProcessParams;
use DedalusSDK\OCR\OCRResponse;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface OCRRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|OCRProcessParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OCRResponse>
     *
     * @throws APIException
     */
    public function process(
        array|OCRProcessParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
