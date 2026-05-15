<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ChatCompletionFunctions.
 *
 * Fields:
 * - description (optional): str
 * - name (required): str
 * - parameters (optional): FunctionParameters
 *
 * @phpstan-type ChatCompletionFunctionsShape = array{
 *   name: string, description?: string|null, parameters?: array<string,mixed>|null
 * }
 */
final class ChatCompletionFunctions implements BaseModel
{
    /** @use SdkModel<ChatCompletionFunctionsShape> */
    use SdkModel;

    /**
     * The name of the function to be called. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 64.
     */
    #[Required]
    public string $name;

    /**
     * A description of what the function does, used by the model to choose when and how to call the function.
     */
    #[Optional]
    public ?string $description;

    /**
     * The parameters the functions accepts, described as a JSON Schema object. See the [guide](/docs/guides/function-calling) for examples, and the [JSON Schema reference](https://json-schema.org/understanding-json-schema/) for documentation about the format.
     *
     * Omitting `parameters` defines a function with an empty parameter list.
     *
     * @var array<string,mixed>|null $parameters
     */
    #[Optional(map: 'mixed')]
    public ?array $parameters;

    /**
     * `new ChatCompletionFunctions()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionFunctions::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionFunctions)->withName(...)
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
     * @param array<string,mixed>|null $parameters
     */
    public static function with(
        string $name,
        ?string $description = null,
        ?array $parameters = null
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $parameters && $self['parameters'] = $parameters;

        return $self;
    }

    /**
     * The name of the function to be called. Must be a-z, A-Z, 0-9, or contain underscores and dashes, with a maximum length of 64.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * A description of what the function does, used by the model to choose when and how to call the function.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The parameters the functions accepts, described as a JSON Schema object. See the [guide](/docs/guides/function-calling) for examples, and the [JSON Schema reference](https://json-schema.org/understanding-json-schema/) for documentation about the format.
     *
     * Omitting `parameters` defines a function with an empty parameter list.
     *
     * @param array<string,mixed> $parameters
     */
    public function withParameters(array $parameters): self
    {
        $self = clone $this;
        $self['parameters'] = $parameters;

        return $self;
    }
}
