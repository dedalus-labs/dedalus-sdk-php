<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Speech\SpeechCreateParams;

/**
 * The format to audio in. Supported formats are `mp3`, `opus`, `aac`, `flac`, `wav`, and `pcm`.
 */
enum ResponseFormat: string
{
    case MP3 = 'mp3';

    case OPUS = 'opus';

    case AAC = 'aac';

    case FLAC = 'flac';

    case WAV = 'wav';

    case PCM = 'pcm';
}
