<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionAudioParam;

use DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Voice\UnionMember1;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\VoiceIDsOrCustomVoice;

/**
 * The voice the model uses to respond. Supported built-in voices are
 * `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `nova`, `onyx`,
 * `sage`, `shimmer`, `marin`, and `cedar`. You may also provide a
 * custom voice object with an `id`, for example `{ "id": "voice_1234" }`.
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
