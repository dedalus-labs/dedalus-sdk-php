<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Chat;

use DedalusSDK\Chat\Completions\ChatCompletion;
use DedalusSDK\Chat\Completions\ChatCompletionChunk;
use DedalusSDK\Chat\Completions\CompletionCreateParams;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Contracts\BaseStream;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface CompletionsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CompletionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ChatCompletion>
     *
     * @throws APIException
     */
    public function create(
        array|CompletionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CompletionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<ChatCompletionChunk>>
     *
     * @throws APIException
     */
    public function createStream(
        array|CompletionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
