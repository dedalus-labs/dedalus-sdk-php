<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Speech\SpeechCreateParams;

/**
 * One of the available [TTS models](/docs/models#tts): `tts-1`, `tts-1-hd`, `gpt-4o-mini-tts`, or `gpt-4o-mini-tts-2025-12-15`.
 */
enum Model: string
{
    case TTS_1 = 'tts-1';

    case TTS_1_HD = 'tts-1-hd';

    case GPT_4O_MINI_TTS = 'gpt-4o-mini-tts';

    case GPT_4O_MINI_TTS_2025_12_15 = 'gpt-4o-mini-tts-2025-12-15';
}
