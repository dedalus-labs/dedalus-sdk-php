<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Audio;

use DedalusSDK\Audio\Speech\SpeechCreateParams;
use DedalusSDK\Audio\Speech\SpeechCreateParams\Model;
use DedalusSDK\Audio\Speech\SpeechCreateParams\ResponseFormat;
use DedalusSDK\Audio\Speech\SpeechCreateParams\StreamFormat;
use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Audio\SpeechRawContract;

/**
 * @phpstan-import-type VoiceShape from \DedalusSDK\Audio\Speech\SpeechCreateParams\Voice
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class SpeechRawService implements SpeechRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Generate speech audio from text.
     *
     * Generates audio from the input text using text-to-speech models. Supports multiple
     * voices and output formats including mp3, opus, aac, flac, wav, and pcm.
     *
     * Returns streaming audio data that can be saved to a file or streamed directly to users.
     *
     * @param array{
     *   input: string,
     *   model: string|Model|value-of<Model>,
     *   voice: VoiceShape,
     *   instructions?: string,
     *   responseFormat?: ResponseFormat|value-of<ResponseFormat>,
     *   speed?: float,
     *   streamFormat?: StreamFormat|value-of<StreamFormat>,
     * }|SpeechCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function create(
        array|SpeechCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpeechCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/audio/speech',
            headers: ['Accept' => 'audio/mpeg'],
            body: (object) $parsed,
            options: $options,
            convert: 'string',
        );
    }
}
