<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionMessageToolCall\Function_;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * A call to a function tool created by the model.
 *
 * Fields:
 * - id (required): str
 * - type (required): Literal["function"]
 * - function (required): ChatCompletionMessageToolCallFunction
 * - thought_signature (optional): str
 *
 * @phpstan-import-type FunctionShape from \DedalusSDK\Chat\Completions\ChatCompletionMessageToolCall\Function_
 *
 * @phpstan-type ChatCompletionMessageToolCallShape = array{
 *   id: string,
 *   function: Function_|FunctionShape,
 *   type: 'function',
 *   thoughtSignature?: string|null,
 * }
 */
final class ChatCompletionMessageToolCall implements BaseModel
{
    /** @use SdkModel<ChatCompletionMessageToolCallShape> */
    use SdkModel;

    /**
     * The type of the tool. Currently, only `function` is supported.
     *
     * @var 'function' $type
     */
    #[Required]
    public string $type = 'function';

    /**
     * The ID of the tool call.
     */
    #[Required]
    public string $id;

    /**
     * The function that the model called.
     *
     * Fields:
     * - name (required): str
     * - arguments (required): str
     */
    #[Required]
    public Function_ $function;

    /**
     * Opaque signature for thought continuity in multi-turn tool use (Google-specific, base64 encoded).
     */
    #[Optional('thought_signature', nullable: true)]
    public ?string $thoughtSignature;

    /**
     * `new ChatCompletionMessageToolCall()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionMessageToolCall::with(id: ..., function: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionMessageToolCall)->withID(...)->withFunction(...)
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
     * @param Function_|FunctionShape $function
     */
    public static function with(
        string $id,
        Function_|array $function,
        ?string $thoughtSignature = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['function'] = $function;

        null !== $thoughtSignature && $self['thoughtSignature'] = $thoughtSignature;

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
     * The function that the model called.
     *
     * Fields:
     * - name (required): str
     * - arguments (required): str
     *
     * @param Function_|FunctionShape $function
     */
    public function withFunction(Function_|array $function): self
    {
        $self = clone $this;
        $self['function'] = $function;

        return $self;
    }

    /**
     * The type of the tool. Currently, only `function` is supported.
     *
     * @param 'function' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Opaque signature for thought continuity in multi-turn tool use (Google-specific, base64 encoded).
     */
    public function withThoughtSignature(?string $thoughtSignature): self
    {
        $self = clone $this;
        $self['thoughtSignature'] = $thoughtSignature;

        return $self;
    }
}
