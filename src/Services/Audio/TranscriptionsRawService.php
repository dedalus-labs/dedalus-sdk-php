<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Audio;

use DedalusSDK\Audio\Transcriptions\TranscriptionCreateParams;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;
use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Audio\TranscriptionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class TranscriptionsRawService implements TranscriptionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   file: string|FileParam,
     *   model: string,
     *   language?: string|null,
     *   prompt?: string|null,
     *   responseFormat?: string|null,
     *   temperature?: float|null,
     * }|TranscriptionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateTranscriptionResponseVerboseJSON|CreateTranscriptionResponseJSON,>
     *
     * @throws APIException
     */
    public function create(
        array|TranscriptionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TranscriptionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/audio/transcriptions',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: TranscriptionNewResponse::class,
        );
    }
}
