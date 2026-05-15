<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Speech\SpeechCreateParams;

/**
 * The format to stream the audio in. Supported formats are `sse` and `audio`. `sse` is not supported for `tts-1` or `tts-1-hd`.
 */
enum StreamFormat: string
{
    case SSE = 'sse';

    case AUDIO = 'audio';
}
