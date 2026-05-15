<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChoiceDeltaToolCall\Function_;
use DedalusSDK\Chat\Completions\ChoiceDeltaToolCall\Type;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ChatCompletionMessageToolCallChunk.
 *
 * Fields:
 * - index (required): int
 * - id (optional): str
 * - type (optional): Literal["function"]
 * - function (optional): ChatCompletionMessageToolCallChunkFunction
 *
 * @phpstan-import-type FunctionShape from \DedalusSDK\Chat\Completions\ChoiceDeltaToolCall\Function_
 *
 * @phpstan-type ChoiceDeltaToolCallShape = array{
 *   index: int,
 *   id?: string|null,
 *   function?: null|Function_|FunctionShape,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class ChoiceDeltaToolCall implements BaseModel
{
    /** @use SdkModel<ChoiceDeltaToolCallShape> */
    use SdkModel;

    #[Required]
    public int $index;

    /**
     * The ID of the tool call.
     */
    #[Optional]
    public ?string $id;

    /**
     * Schema for ChatCompletionMessageToolCallChunkFunction.
     *
     * Fields:
     * - name (optional): str
     * - arguments (optional): str
     */
    #[Optional]
    public ?Function_ $function;

    /**
     * The type of the tool. Currently, only `function` is supported.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new ChoiceDeltaToolCall()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChoiceDeltaToolCall::with(index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChoiceDeltaToolCall)->withIndex(...)
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
     * @param Function_|FunctionShape|null $function
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        int $index,
        ?string $id = null,
        Function_|array|null $function = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['index'] = $index;

        null !== $id && $self['id'] = $id;
        null !== $function && $self['function'] = $function;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

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
     * Schema for ChatCompletionMessageToolCallChunkFunction.
     *
     * Fields:
     * - name (optional): str
     * - arguments (optional): str
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
