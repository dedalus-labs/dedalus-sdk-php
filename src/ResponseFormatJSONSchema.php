<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\ResponseFormatJSONSchema\JSONSchema;

/**
 * JSON Schema response format. Used to generate structured JSON responses.
 * Learn more about [Structured Outputs](/docs/guides/structured-outputs).
 *
 * Fields:
 * - type (required): Literal["json_schema"]
 * - json_schema (required): JSONSchema
 *
 * @phpstan-import-type JSONSchemaShape from \DedalusSDK\ResponseFormatJSONSchema\JSONSchema
 *
 * @phpstan-type ResponseFormatJSONSchemaShape = array{
 *   jsonSchema: JSONSchema|JSONSchemaShape, type: 'json_schema'
 * }
 */
final class ResponseFormatJSONSchema implements BaseModel
{
    /** @use SdkModel<ResponseFormatJSONSchemaShape> */
    use SdkModel;

    /**
     * The type of response format being defined. Always `json_schema`.
     *
     * @var 'json_schema' $type
     */
    #[Required]
    public string $type = 'json_schema';

    /**
     * Structured Outputs configuration options, including a JSON Schema.
     */
    #[Required('json_schema')]
    public JSONSchema $jsonSchema;

    /**
     * `new ResponseFormatJSONSchema()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ResponseFormatJSONSchema::with(jsonSchema: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ResponseFormatJSONSchema)->withJSONSchema(...)
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
     * @param JSONSchema|JSONSchemaShape $jsonSchema
     */
    public static function with(JSONSchema|array $jsonSchema): self
    {
        $self = new self;

        $self['jsonSchema'] = $jsonSchema;

        return $self;
    }

    /**
     * Structured Outputs configuration options, including a JSON Schema.
     *
     * @param JSONSchema|JSONSchemaShape $jsonSchema
     */
    public function withJSONSchema(JSONSchema|array $jsonSchema): self
    {
        $self = clone $this;
        $self['jsonSchema'] = $jsonSchema;

        return $self;
    }

    /**
     * The type of response format being defined. Always `json_schema`.
     *
     * @param 'json_schema' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
