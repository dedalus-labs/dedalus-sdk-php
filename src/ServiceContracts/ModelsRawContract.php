<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Models\ListModelsResponse;
use DedalusSDK\Models\Model;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface ModelsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Model>
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListModelsResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
