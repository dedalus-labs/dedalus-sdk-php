<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\ServiceContracts\ChatContract;
use DedalusSDK\Services\Chat\CompletionsService;

final class ChatService implements ChatContract
{
    /**
     * @api
     */
    public ChatRawService $raw;

    /**
     * @api
     */
    public CompletionsService $completions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ChatRawService($client);
        $this->completions = new CompletionsService($client);
    }
}
