<?php

declare(strict_types=1);

namespace DedalusSDK\ResponseFormatJSONSchema;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Structured Outputs configuration options, including a JSON Schema.
 *
 * @phpstan-type JSONSchemaShape = array{
 *   name: string,
 *   description?: string|null,
 *   schema?: array<string,mixed>|null,
 *   strict?: bool|null,
 * }
 */
final class JSONSchema implements BaseModel
{
    /** @use SdkModel<JSONSchemaShape> */
    use SdkModel;

    /**
     * The name of the response format. Must be a-z, A-Z, 0-9, or contain
     * underscores and dashes, with a maximum length of 64.
     */
    #[Required]
    public string $name;

    /**
     * A description of what the response format is for, used by the model to
     * determine how to respond in the format.
     */
    #[Optional]
    public ?string $description;

    /**
     * The schema for the response format, described as a JSON Schema object.
     * Learn how to build JSON schemas [here](https://json-schema.org/).
     *
     * @var array<string,mixed>|null $schema
     */
    #[Optional(map: 'mixed')]
    public ?array $schema;

    /**
     * Whether to enable strict schema adherence when generating the output.
     * If set to true, the model will always follow the exact schema defined
     * in the `schema` field. Only a subset of JSON Schema is supported when
     * `strict` is `true`. To learn more, read the [Structured Outputs
     * guide](/docs/guides/structured-outputs).
     */
    #[Optional(nullable: true)]
    public ?bool $strict;

    /**
     * `new JSONSchema()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JSONSchema::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JSONSchema)->withName(...)
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
     * @param array<string,mixed>|null $schema
     */
    public static function with(
        string $name,
        ?string $description = null,
        ?array $schema = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $schema && $self['schema'] = $schema;
        null !== $strict && $self['strict'] = $strict;

        return $self;
    }

    /**
     * The name of the response format. Must be a-z, A-Z, 0-9, or contain
     * underscores and dashes, with a maximum length of 64.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * A description of what the response format is for, used by the model to
     * determine how to respond in the format.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The schema for the response format, described as a JSON Schema object.
     * Learn how to build JSON schemas [here](https://json-schema.org/).
     *
     * @param array<string,mixed> $schema
     */
    public function withSchema(array $schema): self
    {
        $self = clone $this;
        $self['schema'] = $schema;

        return $self;
    }

    /**
     * Whether to enable strict schema adherence when generating the output.
     * If set to true, the model will always follow the exact schema defined
     * in the `schema` field. Only a subset of JSON Schema is supported when
     * `strict` is `true`. To learn more, read the [Structured Outputs
     * guide](/docs/guides/structured-outputs).
     */
    public function withStrict(?bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }
}
