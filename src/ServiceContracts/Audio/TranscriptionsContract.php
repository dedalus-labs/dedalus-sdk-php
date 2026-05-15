<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Audio;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface TranscriptionsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string|FileParam $file,
        string $model,
        ?string $language = null,
        ?string $prompt = null,
        ?string $responseFormat = null,
        ?float $temperature = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreateTranscriptionResponseVerboseJSON|CreateTranscriptionResponseJSON;
}
