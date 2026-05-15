<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\ModelSettings\Stop;
use DedalusSDK\ModelSettings\Truncation;
use DedalusSDK\ToolChoice\MCPToolChoice;
use DedalusSDK\ToolChoice\UnionMember0;

/**
 * @phpstan-import-type StopVariants from \DedalusSDK\ModelSettings\Stop
 * @phpstan-import-type ToolChoiceVariants from \DedalusSDK\ToolChoice
 * @phpstan-import-type ReasoningShape from \DedalusSDK\Reasoning
 * @phpstan-import-type StopShape from \DedalusSDK\ModelSettings\Stop
 * @phpstan-import-type ToolChoiceShape from \DedalusSDK\ToolChoice
 *
 * @phpstan-type ModelSettingsShape = array{
 *   attributes?: array<string,mixed>|null,
 *   audio?: array<string,mixed>|null,
 *   deferred?: bool|null,
 *   extraArgs?: array<string,mixed>|null,
 *   extraHeaders?: array<string,string>|null,
 *   extraQuery?: array<string,mixed>|null,
 *   frequencyPenalty?: float|null,
 *   generationConfig?: array<string,mixed>|null,
 *   includeUsage?: bool|null,
 *   inputAudioFormat?: string|null,
 *   inputAudioTranscription?: array<string,mixed>|null,
 *   logitBias?: array<string,int>|null,
 *   logprobs?: bool|null,
 *   maxCompletionTokens?: int|null,
 *   maxTokens?: int|null,
 *   metadata?: array<string,string>|null,
 *   modalities?: list<string>|null,
 *   n?: int|null,
 *   outputAudioFormat?: string|null,
 *   parallelToolCalls?: bool|null,
 *   prediction?: array<string,mixed>|null,
 *   presencePenalty?: float|null,
 *   promptCacheKey?: string|null,
 *   reasoning?: null|Reasoning|ReasoningShape,
 *   reasoningEffort?: string|null,
 *   responseFormat?: array<string,mixed>|null,
 *   safetyIdentifier?: string|null,
 *   safetySettings?: list<mixed>|null,
 *   searchParameters?: array<string,mixed>|null,
 *   seed?: int|null,
 *   serviceTier?: string|null,
 *   stop?: StopShape|null,
 *   store?: bool|null,
 *   stream?: bool|null,
 *   streamOptions?: array<string,mixed>|null,
 *   structuredOutput?: mixed,
 *   systemInstruction?: array<string,mixed>|null,
 *   temperature?: float|null,
 *   thinking?: array<string,mixed>|null,
 *   timeout?: float|null,
 *   toolChoice?: ToolChoiceShape|null,
 *   toolConfig?: array<string,mixed>|null,
 *   topK?: int|null,
 *   topLogprobs?: int|null,
 *   topP?: float|null,
 *   truncation?: null|Truncation|value-of<Truncation>,
 *   turnDetection?: array<string,mixed>|null,
 *   user?: string|null,
 *   verbosity?: string|null,
 *   voice?: string|null,
 *   webSearchOptions?: array<string,mixed>|null,
 * }
 */
final class ModelSettings implements BaseModel
{
    /** @use SdkModel<ModelSettingsShape> */
    use SdkModel;

    /** @var array<string,mixed>|null $attributes */
    #[Optional(map: 'mixed')]
    public ?array $attributes;

    /** @var array<string,mixed>|null $audio */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $audio;

    #[Optional(nullable: true)]
    public ?bool $deferred;

    /** @var array<string,mixed>|null $extraArgs */
    #[Optional('extra_args', map: 'mixed', nullable: true)]
    public ?array $extraArgs;

    /** @var array<string,string>|null $extraHeaders */
    #[Optional('extra_headers', map: 'string', nullable: true)]
    public ?array $extraHeaders;

    /** @var array<string,mixed>|null $extraQuery */
    #[Optional('extra_query', map: 'mixed', nullable: true)]
    public ?array $extraQuery;

    #[Optional('frequency_penalty', nullable: true)]
    public ?float $frequencyPenalty;

    /** @var array<string,mixed>|null $generationConfig */
    #[Optional(
        'generation_config',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $generationConfig;

    #[Optional('include_usage', nullable: true)]
    public ?bool $includeUsage;

    #[Optional('input_audio_format', nullable: true)]
    public ?string $inputAudioFormat;

    /** @var array<string,mixed>|null $inputAudioTranscription */
    #[Optional(
        'input_audio_transcription',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $inputAudioTranscription;

    /** @var array<string,int>|null $logitBias */
    #[Optional('logit_bias', map: 'int', nullable: true)]
    public ?array $logitBias;

    #[Optional(nullable: true)]
    public ?bool $logprobs;

    #[Optional('max_completion_tokens', nullable: true)]
    public ?int $maxCompletionTokens;

    #[Optional('max_tokens', nullable: true)]
    public ?int $maxTokens;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string', nullable: true)]
    public ?array $metadata;

    /** @var list<string>|null $modalities */
    #[Optional(list: 'string', nullable: true)]
    public ?array $modalities;

    #[Optional(nullable: true)]
    public ?int $n;

    #[Optional('output_audio_format', nullable: true)]
    public ?string $outputAudioFormat;

    #[Optional('parallel_tool_calls', nullable: true)]
    public ?bool $parallelToolCalls;

    /** @var array<string,mixed>|null $prediction */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $prediction;

    #[Optional('presence_penalty', nullable: true)]
    public ?float $presencePenalty;

    #[Optional('prompt_cache_key', nullable: true)]
    public ?string $promptCacheKey;

    /**
     * **gpt-5 and o-series models only**.
     *
     * Configuration options for
     * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
     */
    #[Optional(nullable: true)]
    public ?Reasoning $reasoning;

    #[Optional('reasoning_effort', nullable: true)]
    public ?string $reasoningEffort;

    /** @var array<string,mixed>|null $responseFormat */
    #[Optional(
        'response_format',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $responseFormat;

    #[Optional('safety_identifier', nullable: true)]
    public ?string $safetyIdentifier;

    /** @var list<mixed>|null $safetySettings */
    #[Optional(
        'safety_settings',
        list: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $safetySettings;

    /** @var array<string,mixed>|null $searchParameters */
    #[Optional(
        'search_parameters',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $searchParameters;

    #[Optional(nullable: true)]
    public ?int $seed;

    #[Optional('service_tier', nullable: true)]
    public ?string $serviceTier;

    /** @var StopVariants|null $stop */
    #[Optional(union: Stop::class, nullable: true)]
    public string|array|null $stop;

    #[Optional(nullable: true)]
    public ?bool $store;

    #[Optional(nullable: true)]
    public ?bool $stream;

    /** @var array<string,mixed>|null $streamOptions */
    #[Optional(
        'stream_options',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $streamOptions;

    #[Optional('structured_output')]
    public mixed $structuredOutput;

    /** @var array<string,mixed>|null $systemInstruction */
    #[Optional(
        'system_instruction',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $systemInstruction;

    #[Optional(nullable: true)]
    public ?float $temperature;

    /** @var array<string,mixed>|null $thinking */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $thinking;

    #[Optional(nullable: true)]
    public ?float $timeout;

    /** @var ToolChoiceVariants|null $toolChoice */
    #[Optional('tool_choice', union: ToolChoice::class, nullable: true)]
    public string|MCPToolChoice|array|null $toolChoice;

    /** @var array<string,mixed>|null $toolConfig */
    #[Optional(
        'tool_config',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $toolConfig;

    #[Optional('top_k', nullable: true)]
    public ?int $topK;

    #[Optional('top_logprobs', nullable: true)]
    public ?int $topLogprobs;

    #[Optional('top_p', nullable: true)]
    public ?float $topP;

    /** @var value-of<Truncation>|null $truncation */
    #[Optional(enum: Truncation::class, nullable: true)]
    public ?string $truncation;

    /** @var array<string,mixed>|null $turnDetection */
    #[Optional(
        'turn_detection',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $turnDetection;

    #[Optional(nullable: true)]
    public ?string $user;

    #[Optional(nullable: true)]
    public ?string $verbosity;

    #[Optional(nullable: true)]
    public ?string $voice;

    /** @var array<string,mixed>|null $webSearchOptions */
    #[Optional(
        'web_search_options',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $webSearchOptions;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $attributes
     * @param array<string,mixed>|null $audio
     * @param array<string,mixed>|null $extraArgs
     * @param array<string,string>|null $extraHeaders
     * @param array<string,mixed>|null $extraQuery
     * @param array<string,mixed>|null $generationConfig
     * @param array<string,mixed>|null $inputAudioTranscription
     * @param array<string,int>|null $logitBias
     * @param array<string,string>|null $metadata
     * @param list<string>|null $modalities
     * @param array<string,mixed>|null $prediction
     * @param Reasoning|ReasoningShape|null $reasoning
     * @param array<string,mixed>|null $responseFormat
     * @param list<mixed>|null $safetySettings
     * @param array<string,mixed>|null $searchParameters
     * @param StopShape|null $stop
     * @param array<string,mixed>|null $streamOptions
     * @param array<string,mixed>|null $systemInstruction
     * @param array<string,mixed>|null $thinking
     * @param ToolChoiceShape|null $toolChoice
     * @param array<string,mixed>|null $toolConfig
     * @param Truncation|value-of<Truncation>|null $truncation
     * @param array<string,mixed>|null $turnDetection
     * @param array<string,mixed>|null $webSearchOptions
     */
    public static function with(
        ?array $attributes = null,
        ?array $audio = null,
        ?bool $deferred = null,
        ?array $extraArgs = null,
        ?array $extraHeaders = null,
        ?array $extraQuery = null,
        ?float $frequencyPenalty = null,
        ?array $generationConfig = null,
        ?bool $includeUsage = null,
        ?string $inputAudioFormat = null,
        ?array $inputAudioTranscription = null,
        ?array $logitBias = null,
        ?bool $logprobs = null,
        ?int $maxCompletionTokens = null,
        ?int $maxTokens = null,
        ?array $metadata = null,
        ?array $modalities = null,
        ?int $n = null,
        ?string $outputAudioFormat = null,
        ?bool $parallelToolCalls = null,
        ?array $prediction = null,
        ?float $presencePenalty = null,
        ?string $promptCacheKey = null,
        Reasoning|array|null $reasoning = null,
        ?string $reasoningEffort = null,
        ?array $responseFormat = null,
        ?string $safetyIdentifier = null,
        ?array $safetySettings = null,
        ?array $searchParameters = null,
        ?int $seed = null,
        ?string $serviceTier = null,
        string|array|null $stop = null,
        ?bool $store = null,
        ?bool $stream = null,
        ?array $streamOptions = null,
        mixed $structuredOutput = null,
        ?array $systemInstruction = null,
        ?float $temperature = null,
        ?array $thinking = null,
        ?float $timeout = null,
        string|UnionMember0|MCPToolChoice|array|null $toolChoice = null,
        ?array $toolConfig = null,
        ?int $topK = null,
        ?int $topLogprobs = null,
        ?float $topP = null,
        Truncation|string|null $truncation = null,
        ?array $turnDetection = null,
        ?string $user = null,
        ?string $verbosity = null,
        ?string $voice = null,
        ?array $webSearchOptions = null,
    ): self {
        $self = new self;

        null !== $attributes && $self['attributes'] = $attributes;
        null !== $audio && $self['audio'] = $audio;
        null !== $deferred && $self['deferred'] = $deferred;
        null !== $extraArgs && $self['extraArgs'] = $extraArgs;
        null !== $extraHeaders && $self['extraHeaders'] = $extraHeaders;
        null !== $extraQuery && $self['extraQuery'] = $extraQuery;
        null !== $frequencyPenalty && $self['frequencyPenalty'] = $frequencyPenalty;
        null !== $generationConfig && $self['generationConfig'] = $generationConfig;
        null !== $includeUsage && $self['includeUsage'] = $includeUsage;
        null !== $inputAudioFormat && $self['inputAudioFormat'] = $inputAudioFormat;
        null !== $inputAudioTranscription && $self['inputAudioTranscription'] = $inputAudioTranscription;
        null !== $logitBias && $self['logitBias'] = $logitBias;
        null !== $logprobs && $self['logprobs'] = $logprobs;
        null !== $maxCompletionTokens && $self['maxCompletionTokens'] = $maxCompletionTokens;
        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $modalities && $self['modalities'] = $modalities;
        null !== $n && $self['n'] = $n;
        null !== $outputAudioFormat && $self['outputAudioFormat'] = $outputAudioFormat;
        null !== $parallelToolCalls && $self['parallelToolCalls'] = $parallelToolCalls;
        null !== $prediction && $self['prediction'] = $prediction;
        null !== $presencePenalty && $self['presencePenalty'] = $presencePenalty;
        null !== $promptCacheKey && $self['promptCacheKey'] = $promptCacheKey;
        null !== $reasoning && $self['reasoning'] = $reasoning;
        null !== $reasoningEffort && $self['reasoningEffort'] = $reasoningEffort;
        null !== $responseFormat && $self['responseFormat'] = $responseFormat;
        null !== $safetyIdentifier && $self['safetyIdentifier'] = $safetyIdentifier;
        null !== $safetySettings && $self['safetySettings'] = $safetySettings;
        null !== $searchParameters && $self['searchParameters'] = $searchParameters;
        null !== $seed && $self['seed'] = $seed;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $stop && $self['stop'] = $stop;
        null !== $store && $self['store'] = $store;
        null !== $stream && $self['stream'] = $stream;
        null !== $streamOptions && $self['streamOptions'] = $streamOptions;
        null !== $structuredOutput && $self['structuredOutput'] = $structuredOutput;
        null !== $systemInstruction && $self['systemInstruction'] = $systemInstruction;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $timeout && $self['timeout'] = $timeout;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $toolConfig && $self['toolConfig'] = $toolConfig;
        null !== $topK && $self['topK'] = $topK;
        null !== $topLogprobs && $self['topLogprobs'] = $topLogprobs;
        null !== $topP && $self['topP'] = $topP;
        null !== $truncation && $self['truncation'] = $truncation;
        null !== $turnDetection && $self['turnDetection'] = $turnDetection;
        null !== $user && $self['user'] = $user;
        null !== $verbosity && $self['verbosity'] = $verbosity;
        null !== $voice && $self['voice'] = $voice;
        null !== $webSearchOptions && $self['webSearchOptions'] = $webSearchOptions;

        return $self;
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function withAttributes(array $attributes): self
    {
        $self = clone $this;
        $self['attributes'] = $attributes;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $audio
     */
    public function withAudio(?array $audio): self
    {
        $self = clone $this;
        $self['audio'] = $audio;

        return $self;
    }

    public function withDeferred(?bool $deferred): self
    {
        $self = clone $this;
        $self['deferred'] = $deferred;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $extraArgs
     */
    public function withExtraArgs(?array $extraArgs): self
    {
        $self = clone $this;
        $self['extraArgs'] = $extraArgs;

        return $self;
    }

    /**
     * @param array<string,string>|null $extraHeaders
     */
    public function withExtraHeaders(?array $extraHeaders): self
    {
        $self = clone $this;
        $self['extraHeaders'] = $extraHeaders;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $extraQuery
     */
    public function withExtraQuery(?array $extraQuery): self
    {
        $self = clone $this;
        $self['extraQuery'] = $extraQuery;

        return $self;
    }

    public function withFrequencyPenalty(?float $frequencyPenalty): self
    {
        $self = clone $this;
        $self['frequencyPenalty'] = $frequencyPenalty;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $generationConfig
     */
    public function withGenerationConfig(?array $generationConfig): self
    {
        $self = clone $this;
        $self['generationConfig'] = $generationConfig;

        return $self;
    }

    public function withIncludeUsage(?bool $includeUsage): self
    {
        $self = clone $this;
        $self['includeUsage'] = $includeUsage;

        return $self;
    }

    public function withInputAudioFormat(?string $inputAudioFormat): self
    {
        $self = clone $this;
        $self['inputAudioFormat'] = $inputAudioFormat;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $inputAudioTranscription
     */
    public function withInputAudioTranscription(
        ?array $inputAudioTranscription
    ): self {
        $self = clone $this;
        $self['inputAudioTranscription'] = $inputAudioTranscription;

        return $self;
    }

    /**
     * @param array<string,int>|null $logitBias
     */
    public function withLogitBias(?array $logitBias): self
    {
        $self = clone $this;
        $self['logitBias'] = $logitBias;

        return $self;
    }

    public function withLogprobs(?bool $logprobs): self
    {
        $self = clone $this;
        $self['logprobs'] = $logprobs;

        return $self;
    }

    public function withMaxCompletionTokens(?int $maxCompletionTokens): self
    {
        $self = clone $this;
        $self['maxCompletionTokens'] = $maxCompletionTokens;

        return $self;
    }

    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * @param array<string,string>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * @param list<string>|null $modalities
     */
    public function withModalities(?array $modalities): self
    {
        $self = clone $this;
        $self['modalities'] = $modalities;

        return $self;
    }

    public function withN(?int $n): self
    {
        $self = clone $this;
        $self['n'] = $n;

        return $self;
    }

    public function withOutputAudioFormat(?string $outputAudioFormat): self
    {
        $self = clone $this;
        $self['outputAudioFormat'] = $outputAudioFormat;

        return $self;
    }

    public function withParallelToolCalls(?bool $parallelToolCalls): self
    {
        $self = clone $this;
        $self['parallelToolCalls'] = $parallelToolCalls;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $prediction
     */
    public function withPrediction(?array $prediction): self
    {
        $self = clone $this;
        $self['prediction'] = $prediction;

        return $self;
    }

    public function withPresencePenalty(?float $presencePenalty): self
    {
        $self = clone $this;
        $self['presencePenalty'] = $presencePenalty;

        return $self;
    }

    public function withPromptCacheKey(?string $promptCacheKey): self
    {
        $self = clone $this;
        $self['promptCacheKey'] = $promptCacheKey;

        return $self;
    }

    /**
     * **gpt-5 and o-series models only**.
     *
     * Configuration options for
     * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
     *
     * @param Reasoning|ReasoningShape|null $reasoning
     */
    public function withReasoning(Reasoning|array|null $reasoning): self
    {
        $self = clone $this;
        $self['reasoning'] = $reasoning;

        return $self;
    }

    public function withReasoningEffort(?string $reasoningEffort): self
    {
        $self = clone $this;
        $self['reasoningEffort'] = $reasoningEffort;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $responseFormat
     */
    public function withResponseFormat(?array $responseFormat): self
    {
        $self = clone $this;
        $self['responseFormat'] = $responseFormat;

        return $self;
    }

    public function withSafetyIdentifier(?string $safetyIdentifier): self
    {
        $self = clone $this;
        $self['safetyIdentifier'] = $safetyIdentifier;

        return $self;
    }

    /**
     * @param list<mixed>|null $safetySettings
     */
    public function withSafetySettings(?array $safetySettings): self
    {
        $self = clone $this;
        $self['safetySettings'] = $safetySettings;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $searchParameters
     */
    public function withSearchParameters(?array $searchParameters): self
    {
        $self = clone $this;
        $self['searchParameters'] = $searchParameters;

        return $self;
    }

    public function withSeed(?int $seed): self
    {
        $self = clone $this;
        $self['seed'] = $seed;

        return $self;
    }

    public function withServiceTier(?string $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * @param StopShape|null $stop
     */
    public function withStop(string|array|null $stop): self
    {
        $self = clone $this;
        $self['stop'] = $stop;

        return $self;
    }

    public function withStore(?bool $store): self
    {
        $self = clone $this;
        $self['store'] = $store;

        return $self;
    }

    public function withStream(?bool $stream): self
    {
        $self = clone $this;
        $self['stream'] = $stream;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $streamOptions
     */
    public function withStreamOptions(?array $streamOptions): self
    {
        $self = clone $this;
        $self['streamOptions'] = $streamOptions;

        return $self;
    }

    public function withStructuredOutput(mixed $structuredOutput): self
    {
        $self = clone $this;
        $self['structuredOutput'] = $structuredOutput;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $systemInstruction
     */
    public function withSystemInstruction(?array $systemInstruction): self
    {
        $self = clone $this;
        $self['systemInstruction'] = $systemInstruction;

        return $self;
    }

    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $thinking
     */
    public function withThinking(?array $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    public function withTimeout(?float $timeout): self
    {
        $self = clone $this;
        $self['timeout'] = $timeout;

        return $self;
    }

    /**
     * @param ToolChoiceShape|null $toolChoice
     */
    public function withToolChoice(
        string|UnionMember0|MCPToolChoice|array|null $toolChoice
    ): self {
        $self = clone $this;
        $self['toolChoice'] = $toolChoice;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $toolConfig
     */
    public function withToolConfig(?array $toolConfig): self
    {
        $self = clone $this;
        $self['toolConfig'] = $toolConfig;

        return $self;
    }

    public function withTopK(?int $topK): self
    {
        $self = clone $this;
        $self['topK'] = $topK;

        return $self;
    }

    public function withTopLogprobs(?int $topLogprobs): self
    {
        $self = clone $this;
        $self['topLogprobs'] = $topLogprobs;

        return $self;
    }

    public function withTopP(?float $topP): self
    {
        $self = clone $this;
        $self['topP'] = $topP;

        return $self;
    }

    /**
     * @param Truncation|value-of<Truncation>|null $truncation
     */
    public function withTruncation(Truncation|string|null $truncation): self
    {
        $self = clone $this;
        $self['truncation'] = $truncation;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $turnDetection
     */
    public function withTurnDetection(?array $turnDetection): self
    {
        $self = clone $this;
        $self['turnDetection'] = $turnDetection;

        return $self;
    }

    public function withUser(?string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }

    public function withVerbosity(?string $verbosity): self
    {
        $self = clone $this;
        $self['verbosity'] = $verbosity;

        return $self;
    }

    public function withVoice(?string $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $webSearchOptions
     */
    public function withWebSearchOptions(?array $webSearchOptions): self
    {
        $self = clone $this;
        $self['webSearchOptions'] = $webSearchOptions;

        return $self;
    }
}
