<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Audio;

use DedalusSDK\Audio\Translations\TranslationCreateParams;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseJSON;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface TranslationsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TranslationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateTranslationResponseVerboseJSON|CreateTranslationResponseJSON,>
     *
     * @throws APIException
     */
    public function create(
        array|TranslationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
