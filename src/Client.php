<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\BaseClient;
use DedalusSDK\Core\Implementation\StreamingHttpClient;
use DedalusSDK\Core\Util;
use DedalusSDK\Services\AudioService;
use DedalusSDK\Services\ChatService;
use DedalusSDK\Services\EmbeddingsService;
use DedalusSDK\Services\ImagesService;
use DedalusSDK\Services\ModelsService;
use DedalusSDK\Services\OCRService;
use DedalusSDK\Services\ResponsesService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;

/**
 * @phpstan-import-type NormalizedRequest from \DedalusSDK\Core\BaseClient
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $xAPIKey;

    public string $asBaseURL;

    public string $dedalusOrgID;

    public string $provider;

    public string $providerKey;

    public string $providerModel;

    /**
     * @api
     */
    public ModelsService $models;

    /**
     * @api
     */
    public EmbeddingsService $embeddings;

    /**
     * @api
     */
    public AudioService $audio;

    /**
     * @api
     */
    public ImagesService $images;

    /**
     * @api
     */
    public OCRService $ocr;

    /**
     * @api
     */
    public ResponsesService $responses;

    /**
     * @api
     */
    public ChatService $chat;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $xAPIKey = null,
        ?string $asBaseURL = null,
        ?string $dedalusOrgID = null,
        ?string $provider = null,
        ?string $providerKey = null,
        ?string $providerModel = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? Util::getenv('DEDALUS_API_KEY'));
        $this->xAPIKey = (string) ($xAPIKey ?? Util::getenv('DEDALUS_X_API_KEY'));
        $this->asBaseURL = (string) ($asBaseURL ?? Util::getenv(
            'DEDALUS_AS_URL'
        ) ?: 'https://as.dedaluslabs.ai');
        $this->dedalusOrgID = (string) ($dedalusOrgID ?? Util::getenv(
            'DEDALUS_ORG_ID'
        ));
        $this->provider = (string) ($provider ?? Util::getenv('DEDALUS_PROVIDER'));
        $this->providerKey = (string) ($providerKey ?? Util::getenv(
            'DEDALUS_PROVIDER_KEY'
        ));
        $this->providerModel = (string) ($providerModel ?? Util::getenv(
            'DEDALUS_PROVIDER_MODEL'
        ));

        $baseUrl ??= Util::getenv(
            'DEDALUS_BASE_URL'
        ) ?: 'https://api.dedaluslabs.ai';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        if (is_null($options->streamingTransporter)) {
            assert(!is_null($options->transporter));
            $options->streamingTransporter = new StreamingHttpClient($options->transporter);
        }

        /** @var array<string, string|null> $headers */
        $headers = [
            'User-Agent' => sprintf('Dedalus/PHP %s', VERSION),
            'X-SDK-Version' => '1.0.0',
            'X-Provider' => $this->provider,
            'X-Provider-Key' => $this->providerKey,
            'X-Provider-Model' => $this->providerModel,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Stainless-Lang' => 'php',
            'X-Stainless-Package-Version' => '0.0.1',
            'X-Stainless-Arch' => Util::machtype(),
            'X-Stainless-OS' => Util::ostype(),
            'X-Stainless-Runtime' => php_sapi_name(),
            'X-Stainless-Runtime-Version' => phpversion(),
        ];

        $customHeadersEnv = Util::getenv('DEDALUS_CUSTOM_HEADERS');
        if (null !== $customHeadersEnv) {
            foreach (explode("\n", $customHeadersEnv) as $line) {
                $colon = strpos($line, ':');
                if (false !== $colon) {
                    $headers[trim(substr($line, 0, $colon))] = trim(substr($line, $colon + 1));
                }
            }
        }

        parent::__construct(
            headers: $headers,
            baseUrl: $baseUrl,
            options: $options,
            idempotencyHeader: 'Idempotency-Key'
        );

        $this->models = new ModelsService($this);
        $this->embeddings = new EmbeddingsService($this);
        $this->audio = new AudioService($this);
        $this->images = new ImagesService($this);
        $this->ocr = new OCRService($this);
        $this->responses = new ResponsesService($this);
        $this->chat = new ChatService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->bearer(), ...$this->apiKeyAuth()];
    }

    /** @return array<string,string> */
    protected function bearer(): array
    {
        return $this->apiKey ? ['Authorization' => "Bearer {$this->apiKey}"] : [];
    }

    /** @return array<string,string> */
    protected function apiKeyAuth(): array
    {
        return $this->xAPIKey ? ['x-api-key' => $this->xAPIKey] : [];
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }
}
