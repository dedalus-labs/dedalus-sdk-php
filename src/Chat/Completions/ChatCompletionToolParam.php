<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionToolParam\Type;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\FunctionDefinition;

/**
 * Schema for Tool.
 *
 * Fields:
 * - type (optional): ToolTypes
 * - function (required): Function
 *
 * @phpstan-import-type FunctionDefinitionShape from \DedalusSDK\FunctionDefinition
 *
 * @phpstan-type ChatCompletionToolParamShape = array{
 *   function: FunctionDefinition|FunctionDefinitionShape,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class ChatCompletionToolParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionToolParamShape> */
    use SdkModel;

    /**
     * Schema for Function.
     *
     * Fields:
     * - name (required): str
     */
    #[Required]
    public FunctionDefinition $function;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new ChatCompletionToolParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionToolParam::with(function: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionToolParam)->withFunction(...)
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
     * @param FunctionDefinition|FunctionDefinitionShape $function
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        FunctionDefinition|array $function,
        Type|string|null $type = null
    ): self {
        $self = new self;

        $self['function'] = $function;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Schema for Function.
     *
     * Fields:
     * - name (required): str
     *
     * @param FunctionDefinition|FunctionDefinitionShape $function
     */
    public function withFunction(FunctionDefinition|array $function): self
    {
        $self = clone $this;
        $self['function'] = $function;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
