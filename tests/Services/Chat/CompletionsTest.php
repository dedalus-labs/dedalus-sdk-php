<?php

namespace Tests\Services\Chat;

use DedalusSDK\Chat\Completions\ChatCompletion;
use DedalusSDK\Client;
use DedalusSDK\Core\Util;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class CompletionsTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->chat->completions->create(model: 'openai/gpt-5');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ChatCompletion::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->chat->completions->create(
            model: 'openai/gpt-5',
            agentAttributes: ['accuracy' => 0.9, 'complexity' => 0.8],
            audio: ['format' => 'mp3', 'voice' => 'alloy'],
            automaticToolExecution: true,
            cachedContent: 'cached_content',
            correlationID: 'correlation_id',
            credentials: [
                'connectionName' => 'external-service',
                'values' => ['api_key' => 'sk-...'],
            ],
            deferred: true,
            deferredCalls: [
                [
                    'id' => 'id',
                    'name' => 'name',
                    'arguments' => ['foo' => 'string'],
                    'blockedBy' => ['string'],
                    'dependencies' => ['string'],
                    'venue' => 'venue',
                ],
            ],
            frequencyPenalty: -2,
            functionCall: 'function_call',
            functions: [
                [
                    'name' => 'name',
                    'description' => 'description',
                    'parameters' => ['foo' => 'bar'],
                ],
            ],
            generationConfig: ['foo' => 'string'],
            guardrails: [['foo' => 'bar']],
            handoffConfig: ['foo' => 'bar'],
            handoffMode: true,
            inferenceGeo: 'inference_geo',
            logitBias: ['foo' => 0],
            logprobs: true,
            maxCompletionTokens: 0,
            maxTokens: 1,
            maxTurns: 5,
            mcpServers: 'dedalus-labs/example-server',
            messages: [
                ['content' => 'string', 'role' => 'developer', 'name' => 'name'],
            ],
            metadata: ['foo' => 'string'],
            modalities: ['string'],
            modelAttributes: ['gpt-5' => ['accuracy' => 0.95, 'speed' => 0.6]],
            n: 1,
            outputConfig: ['foo' => 'string'],
            parallelToolCalls: true,
            prediction: ['content' => 'string', 'type' => 'content'],
            presencePenalty: -2,
            promptCacheKey: 'prompt_cache_key',
            promptCacheRetention: 'prompt_cache_retention',
            promptMode: 'reasoning',
            reasoningEffort: 'reasoning_effort',
            responseFormat: ['type' => 'text'],
            safePrompt: true,
            safetyIdentifier: 'safety_identifier',
            safetySettings: [
                [
                    'category' => 'HARM_CATEGORY_UNSPECIFIED',
                    'threshold' => 'HARM_BLOCK_THRESHOLD_UNSPECIFIED',
                ],
            ],
            searchParameters: ['foo' => 'string'],
            seed: 0,
            serviceTier: 'service_tier',
            speed: 'standard',
            stop: ['string'],
            store: true,
            streamOptions: ['foo' => 'string'],
            systemInstruction: ['foo' => 'string'],
            temperature: 0,
            thinking: ['budgetTokens' => 1024, 'type' => 'enabled'],
            toolChoice: 'string',
            toolConfig: ['foo' => 'string'],
            tools: [['function' => ['name' => 'name'], 'type' => 'function']],
            topK: 0,
            topLogprobs: 0,
            topP: 0,
            user: 'user',
            verbosity: 'verbosity',
            webSearchOptions: ['foo' => 'string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ChatCompletion::class, $result);
    }
}
