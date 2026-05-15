<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionMessageCustomToolCall\Custom;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * A call to a custom tool created by the model.
 *
 * Fields:
 * - id (required): str
 * - type (required): Literal["custom"]
 * - custom (required): ChatCompletionMessageCustomToolCallCustom
 *
 * @phpstan-import-type CustomShape from \DedalusSDK\Chat\Completions\ChatCompletionMessageCustomToolCall\Custom
 *
 * @phpstan-type ChatCompletionMessageCustomToolCallShape = array{
 *   id: string, custom: Custom|CustomShape, type: 'custom'
 * }
 */
final class ChatCompletionMessageCustomToolCall implements BaseModel
{
    /** @use SdkModel<ChatCompletionMessageCustomToolCallShape> */
    use SdkModel;

    /**
     * The type of the tool. Always `custom`.
     *
     * @var 'custom' $type
     */
    #[Required]
    public string $type = 'custom';

    /**
     * The ID of the tool call.
     */
    #[Required]
    public string $id;

    /**
     * The custom tool that the model called.
     *
     * Fields:
     * - name (required): str
     * - input (required): str
     */
    #[Required]
    public Custom $custom;

    /**
     * `new ChatCompletionMessageCustomToolCall()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionMessageCustomToolCall::with(id: ..., custom: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionMessageCustomToolCall)->withID(...)->withCustom(...)
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
     * @param Custom|CustomShape $custom
     */
    public static function with(string $id, Custom|array $custom): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['custom'] = $custom;

        return $self;
    }

    /**
     * The ID of the tool call.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The custom tool that the model called.
     *
     * Fields:
     * - name (required): str
     * - input (required): str
     *
     * @param Custom|CustomShape $custom
     */
    public function withCustom(Custom|array $custom): self
    {
        $self = clone $this;
        $self['custom'] = $custom;

        return $self;
    }

    /**
     * The type of the tool. Always `custom`.
     *
     * @param 'custom' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
