<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionAudioParam;

/**
 * Specifies the output audio format. Must be one of `wav`, `mp3`, `flac`,
 * `opus`, or `pcm16`.
 */
enum Format: string
{
    case WAV = 'wav';

    case AAC = 'aac';

    case MP3 = 'mp3';

    case FLAC = 'flac';

    case OPUS = 'opus';

    case PCM16 = 'pcm16';
}
