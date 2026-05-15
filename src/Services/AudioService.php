<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\ServiceContracts\AudioContract;
use DedalusSDK\Services\Audio\SpeechService;
use DedalusSDK\Services\Audio\TranscriptionsService;
use DedalusSDK\Services\Audio\TranslationsService;

final class AudioService implements AudioContract
{
    /**
     * @api
     */
    public AudioRawService $raw;

    /**
     * @api
     */
    public SpeechService $speech;

    /**
     * @api
     */
    public TranscriptionsService $transcriptions;

    /**
     * @api
     */
    public TranslationsService $translations;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AudioRawService($client);
        $this->speech = new SpeechService($client);
        $this->transcriptions = new TranscriptionsService($client);
        $this->translations = new TranslationsService($client);
    }
}
