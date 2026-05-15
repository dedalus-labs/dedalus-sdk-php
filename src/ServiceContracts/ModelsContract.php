<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Models\ListModelsResponse;
use DedalusSDK\Models\Model;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface ModelsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        RequestOptions|array|null $requestOptions = null
    ): Model;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): ListModelsResponse;
}
