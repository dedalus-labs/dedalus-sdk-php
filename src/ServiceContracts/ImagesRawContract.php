<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Images\ImageCreateVariationParams;
use DedalusSDK\Images\ImageEditParams;
use DedalusSDK\Images\ImageGenerateParams;
use DedalusSDK\Images\ImagesResponse;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface ImagesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ImageCreateVariationParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function createVariation(
        array|ImageCreateVariationParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ImageEditParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function edit(
        array|ImageEditParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ImageGenerateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function generate(
        array|ImageGenerateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
