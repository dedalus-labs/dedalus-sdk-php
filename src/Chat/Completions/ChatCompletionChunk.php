<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionChunk\ServiceTier;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Represents a streamed chunk of a chat completion response returned
 * by the model, based on the provided input.
 * [Learn more](/docs/guides/streaming-responses).
 *
 * Fields:
 * - id (required): str
 * - choices (required): list[ChatCompletionStreamResponseChoicesItem]
 * - created (required): int
 * - model (required): str
 * - service_tier (optional): ServiceTier
 * - system_fingerprint (optional): str
 * - object (required): Literal["chat.completion.chunk"]
 * - usage (optional): CompletionUsage
 *
 * @phpstan-import-type StreamChoiceShape from \DedalusSDK\Chat\Completions\StreamChoice
 * @phpstan-import-type CompletionUsageShape from \DedalusSDK\Chat\Completions\CompletionUsage
 *
 * @phpstan-type ChatCompletionChunkShape = array{
 *   id: string,
 *   choices: list<StreamChoice|StreamChoiceShape>,
 *   created: int,
 *   model: string,
 *   object: 'chat.completion.chunk',
 *   serviceTier?: null|ServiceTier|value-of<ServiceTier>,
 *   systemFingerprint?: string|null,
 *   usage?: null|CompletionUsage|CompletionUsageShape,
 * }
 */
final class ChatCompletionChunk implements BaseModel
{
    /** @use SdkModel<ChatCompletionChunkShape> */
    use SdkModel;

    /**
     * The object type, which is always `chat.completion.chunk`.
     *
     * @var 'chat.completion.chunk' $object
     */
    #[Required]
    public string $object = 'chat.completion.chunk';

    /**
     * A unique identifier for the chat completion. Each chunk has the same ID.
     */
    #[Required]
    public string $id;

    /**
     * A list of chat completion choices. Can contain more than one elements if `n` is greater than 1. Can also be empty for the
     * last chunk if you set `stream_options: {"include_usage": true}`.
     *
     * @var list<StreamChoice> $choices
     */
    #[Required(list: StreamChoice::class)]
    public array $choices;

    /**
     * The Unix timestamp (in seconds) of when the chat completion was created. Each chunk has the same timestamp.
     */
    #[Required]
    public int $created;

    /**
     * The model to generate the completion.
     */
    #[Required]
    public string $model;

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Optional('service_tier', enum: ServiceTier::class, nullable: true)]
    public ?string $serviceTier;

    /**
     * This fingerprint represents the backend configuration that the model runs with.
     * Can be used in conjunction with the `seed` request parameter to understand when backend changes have been made that might impact determinism.
     */
    #[Optional('system_fingerprint')]
    public ?string $systemFingerprint;

    /**
     * Usage statistics for the completion request.
     *
     * Fields:
     * - completion_tokens (required): int
     * - prompt_tokens (required): int
     * - total_tokens (required): int
     * - completion_tokens_details (optional): CompletionTokensDetails
     * - prompt_tokens_details (optional): PromptTokensDetails
     */
    #[Optional(nullable: true)]
    public ?CompletionUsage $usage;

    /**
     * `new ChatCompletionChunk()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionChunk::with(id: ..., choices: ..., created: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionChunk)
     *   ->withID(...)
     *   ->withChoices(...)
     *   ->withCreated(...)
     *   ->withModel(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<StreamChoice|StreamChoiceShape> $choices
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     * @param CompletionUsage|CompletionUsageShape|null $usage
     */
    public static function with(
        string $id,
        array $choices,
        int $created,
        string $model,
        ServiceTier|string|null $serviceTier = null,
        ?string $systemFingerprint = null,
        CompletionUsage|array|null $usage = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['choices'] = $choices;
        $self['created'] = $created;
        $self['model'] = $model;

        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $systemFingerprint && $self['systemFingerprint'] = $systemFingerprint;
        null !== $usage && $self['usage'] = $usage;

        return $self;
    }

    /**
     * A unique identifier for the chat completion. Each chunk has the same ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A list of chat completion choices. Can contain more than one elements if `n` is greater than 1. Can also be empty for the
     * last chunk if you set `stream_options: {"include_usage": true}`.
     *
     * @param list<StreamChoice|StreamChoiceShape> $choices
     */
    public function withChoices(array $choices): self
    {
        $self = clone $this;
        $self['choices'] = $choices;

        return $self;
    }

    /**
     * The Unix timestamp (in seconds) of when the chat completion was created. Each chunk has the same timestamp.
     */
    public function withCreated(int $created): self
    {
        $self = clone $this;
        $self['created'] = $created;

        return $self;
    }

    /**
     * The model to generate the completion.
     */
    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The object type, which is always `chat.completion.chunk`.
     *
     * @param 'chat.completion.chunk' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     *
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public function withServiceTier(ServiceTier|string|null $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * This fingerprint represents the backend configuration that the model runs with.
     * Can be used in conjunction with the `seed` request parameter to understand when backend changes have been made that might impact determinism.
     */
    public function withSystemFingerprint(string $systemFingerprint): self
    {
        $self = clone $this;
        $self['systemFingerprint'] = $systemFingerprint;

        return $self;
    }

    /**
     * Usage statistics for the completion request.
     *
     * Fields:
     * - completion_tokens (required): int
     * - prompt_tokens (required): int
     * - total_tokens (required): int
     * - completion_tokens_details (optional): CompletionTokensDetails
     * - prompt_tokens_details (optional): PromptTokensDetails
     *
     * @param CompletionUsage|CompletionUsageShape|null $usage
     */
    public function withUsage(CompletionUsage|array|null $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
