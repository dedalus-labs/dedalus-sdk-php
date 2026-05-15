<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Audio;

use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseJSON;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON;
use DedalusSDK\Client;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\Core\Util;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Audio\TranslationsContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class TranslationsService implements TranslationsContract
{
    /**
     * @api
     */
    public TranslationsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TranslationsRawService($client);
    }

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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string|FileParam $file,
        string $model,
        ?string $prompt = null,
        ?string $responseFormat = null,
        ?float $temperature = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreateTranslationResponseVerboseJSON|CreateTranslationResponseJSON {
        $params = Util::removeNulls(
            [
                'file' => $file,
                'model' => $model,
                'prompt' => $prompt,
                'responseFormat' => $responseFormat,
                'temperature' => $temperature,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
