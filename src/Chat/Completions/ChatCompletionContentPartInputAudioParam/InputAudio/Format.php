<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam\InputAudio;

/**
 * The format of the encoded audio data. Currently supports "wav" and "mp3".
 */
enum Format: string
{
    case WAV = 'wav';

    case MP3 = 'mp3';
}
