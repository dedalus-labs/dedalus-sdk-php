<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Audio;

use DedalusSDK\Audio\Speech\SpeechCreateParams\Model;
use DedalusSDK\Audio\Speech\SpeechCreateParams\ResponseFormat;
use DedalusSDK\Audio\Speech\SpeechCreateParams\StreamFormat;
use DedalusSDK\Audio\Speech\SpeechCreateParams\Voice\UnionMember1;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;
use DedalusSDK\VoiceIDsOrCustomVoice;

/**
 * @phpstan-import-type VoiceShape from \DedalusSDK\Audio\Speech\SpeechCreateParams\Voice
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface SpeechContract
{
    /**
     * @api
     *
     * @param string $input The text to generate audio for. The maximum length is 4096 characters.
     * @param string|Model|value-of<Model> $model one of the available [TTS models](/docs/models#tts): `tts-1`, `tts-1-hd`, `gpt-4o-mini-tts`, or `gpt-4o-mini-tts-2025-12-15`
     * @param VoiceShape $voice The voice to use when generating the audio. Supported built-in voices are `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `onyx`, `nova`, `sage`, `shimmer`, `verse`, `marin`, and `cedar`. You may also provide a custom voice object with an `id`, for example `{ "id": "voice_1234" }`. Previews of the voices are available in the [Text to speech guide](/docs/guides/text-to-speech#voice-options).
     * @param string $instructions Control the voice of your generated audio with additional instructions. Does not work with `tts-1` or `tts-1-hd`.
     * @param ResponseFormat|value-of<ResponseFormat> $responseFormat The format to audio in. Supported formats are `mp3`, `opus`, `aac`, `flac`, `wav`, and `pcm`.
     * @param float $speed The speed of the generated audio. Select a value from `0.25` to `4.0`. `1.0` is the default.
     * @param StreamFormat|value-of<StreamFormat> $streamFormat The format to stream the audio in. Supported formats are `sse` and `audio`. `sse` is not supported for `tts-1` or `tts-1-hd`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $input,
        Model|string $model,
        string|UnionMember1|VoiceIDsOrCustomVoice|array $voice,
        ?string $instructions = null,
        ResponseFormat|string $responseFormat = 'mp3',
        float $speed = 1,
        StreamFormat|string $streamFormat = 'audio',
        RequestOptions|array|null $requestOptions = null,
    ): string;
}
