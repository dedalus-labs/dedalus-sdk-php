<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Audio;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;
use DedalusSDK\Client;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\Core\Util;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Audio\TranscriptionsContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class TranscriptionsService implements TranscriptionsContract
{
    /**
     * @api
     */
    public TranscriptionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TranscriptionsRawService($client);
    }

    /**
     * @api
     *
     * Transcribe audio into text.
     *
     * Transcribes audio files using OpenAI's Whisper model. Supports multiple audio formats
     * including mp3, mp4, mpeg, mpga, m4a, wav, and webm. Maximum file size is 25 MB.
     *
     * Args:
     *     file: Audio file to transcribe (required)
     *     model: Model ID to use (e.g., "openai/whisper-1")
     *     language: ISO-639-1 language code (e.g., "en", "es") - improves accuracy
     *     prompt: Optional text to guide the model's style
     *     response_format: Format of the output (json, text, srt, verbose_json, vtt)
     *     temperature: Sampling temperature between 0 and 1
     *
     * Returns:
     *     Transcription object with the transcribed text
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
    ): CreateTranscriptionResponseVerboseJSON|CreateTranscriptionResponseJSON {
        $params = Util::removeNulls(
            [
                'file' => $file,
                'model' => $model,
                'language' => $language,
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
