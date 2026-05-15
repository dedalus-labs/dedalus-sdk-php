<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Speech\SpeechCreateParams;

use DedalusSDK\Audio\Speech\SpeechCreateParams\Voice\UnionMember1;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\VoiceIDsOrCustomVoice;

/**
 * The voice to use when generating the audio. Supported built-in voices are `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `onyx`, `nova`, `sage`, `shimmer`, `verse`, `marin`, and `cedar`. You may also provide a custom voice object with an `id`, for example `{ "id": "voice_1234" }`. Previews of the voices are available in the [Text to speech guide](/docs/guides/text-to-speech#voice-options).
 *
 * @phpstan-import-type VoiceIDsOrCustomVoiceShape from \DedalusSDK\VoiceIDsOrCustomVoice
 *
 * @phpstan-type VoiceVariants = string|VoiceIDsOrCustomVoice|value-of<UnionMember1>
 * @phpstan-type VoiceShape = VoiceVariants|VoiceIDsOrCustomVoiceShape
 */
final class Voice implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', UnionMember1::class, VoiceIDsOrCustomVoice::class];
    }
}
