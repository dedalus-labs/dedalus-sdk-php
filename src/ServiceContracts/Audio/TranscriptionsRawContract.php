<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Audio;

use DedalusSDK\Audio\Transcriptions\TranscriptionCreateParams;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface TranscriptionsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TranscriptionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateTranscriptionResponseVerboseJSON|CreateTranscriptionResponseJSON,>
     *
     * @throws APIException
     */
    public function create(
        array|TranscriptionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
