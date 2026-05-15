<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\ResponseFormatJSONObject;
use DedalusSDK\ResponseFormatJSONSchema;
use DedalusSDK\ResponseFormatText;

/**
 * An object specifying the format that the model must output.  Setting to `{ "type": "json_schema", "json_schema": {...} }` enables Structured Outputs which ensures the model will match your supplied JSON schema. Learn more in the [Structured Outputs guide](/docs/guides/structured-outputs).  Setting to `{ "type": "json_object" }` enables the older JSON mode, which ensures the message the model generates is valid JSON. Using `json_schema` is preferred for models that support it.
 *
 * @phpstan-import-type ResponseFormatTextShape from \DedalusSDK\ResponseFormatText
 * @phpstan-import-type ResponseFormatJSONSchemaShape from \DedalusSDK\ResponseFormatJSONSchema
 * @phpstan-import-type ResponseFormatJSONObjectShape from \DedalusSDK\ResponseFormatJSONObject
 *
 * @phpstan-type ResponseFormatVariants = ResponseFormatText|ResponseFormatJSONSchema|ResponseFormatJSONObject
 * @phpstan-type ResponseFormatShape = ResponseFormatVariants|ResponseFormatTextShape|ResponseFormatJSONSchemaShape|ResponseFormatJSONObjectShape
 */
final class ResponseFormat implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'text' => ResponseFormatText::class,
            'json_schema' => ResponseFormatJSONSchema::class,
            'json_object' => ResponseFormatJSONObject::class,
        ];
    }
}
