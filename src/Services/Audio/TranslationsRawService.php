<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Audio;

use DedalusSDK\Audio\Translations\TranslationCreateParams;
use DedalusSDK\Audio\Translations\TranslationNewResponse;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseJSON;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON;
use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Audio\TranslationsRawContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class TranslationsRawService implements TranslationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Translate audio into English.
     *
     * Translates audio files in any supported language to English text using OpenAI's
     * Whisper model. Supports the same audio formats as transcription. Maximum file size
     * is 25 MB.
     *
     * Args:
     *     file: Audio file to translate (required)
     *     model: Model ID to use (e.g., "openai/whisper-1")
     *     prompt: Optional text to guide the model's style
     *     response_format: Format of the output (json, text, srt, verbose_json, vtt)
     *     temperature: Sampling temperature between 0 and 1
     *
     * Returns:
     *     Translation object with the English translation
     *
     * @param array{
     *   file: string|FileParam,
     *   model: string,
     *   prompt?: string|null,
     *   responseFormat?: string|null,
     *   temperature?: float|null,
     * }|TranslationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateTranslationResponseVerboseJSON|CreateTranslationResponseJSON,>
     *
     * @throws APIException
     */
    public function create(
        array|TranslationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TranslationCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/audio/translations',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: TranslationNewResponse::class,
        );
    }
}
