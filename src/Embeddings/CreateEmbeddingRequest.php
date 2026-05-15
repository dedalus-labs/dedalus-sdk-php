<?php

declare(strict_types=1);

namespace DedalusSDK\Embeddings;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Embeddings\CreateEmbeddingRequest\EncodingFormat;
use DedalusSDK\Embeddings\CreateEmbeddingRequest\Input;
use DedalusSDK\Embeddings\CreateEmbeddingRequest\Model;

/**
 * Schema for EmbeddingRequest.
 *
 * Fields:
 * - input (required): str | Annotated[list[str], MinLen(1), MaxLen(2048), ArrayTitle("EmbeddingRequestInputArray")] | Annotated[list[int], MinLen(1), MaxLen(2048), ArrayTitle("EmbeddingRequestInputArray")] | Annotated[list[Annotated[list[int], MinLen(1), ArrayTitle("EmbeddingRequestInputItemArray")]], MinLen(1), MaxLen(2048), ArrayTitle("EmbeddingRequestInputArray")]
 * - model (required): str | Literal["text-embedding-ada-002", "text-embedding-3-small", "text-embedding-3-large"]
 * - encoding_format (optional): Literal["float", "base64"]
 * - dimensions (optional): int
 * - user (optional): str
 *
 * @phpstan-import-type InputVariants from \DedalusSDK\Embeddings\CreateEmbeddingRequest\Input
 * @phpstan-import-type InputShape from \DedalusSDK\Embeddings\CreateEmbeddingRequest\Input
 *
 * @phpstan-type CreateEmbeddingRequestShape = array{
 *   input: InputShape,
 *   model: string|Model|value-of<Model>,
 *   dimensions?: int|null,
 *   encodingFormat?: null|EncodingFormat|value-of<EncodingFormat>,
 *   user?: string|null,
 * }
 */
final class CreateEmbeddingRequest implements BaseModel
{
    /** @use SdkModel<CreateEmbeddingRequestShape> */
    use SdkModel;

    /**
     * Input text to embed, encoded as a string or array of tokens. To embed multiple inputs in a single request, pass an array of strings or array of token arrays. The input must not exceed the max input tokens for the model (8192 tokens for all embedding models), cannot be an empty string, and any array must be 2048 dimensions or less. [Example Python code](https://cookbook.openai.com/examples/how_to_count_tokens_with_tiktoken) for counting tokens. In addition to the per-input token limit, all embedding  models enforce a maximum of 300,000 tokens summed across all inputs in a  single request.
     *
     * @var InputVariants $input
     */
    #[Required(union: Input::class)]
    public string|array $input;

    /**
     * ID of the model to use. You can use the [List models](/docs/api-reference/models/list) API to see all of your available models, or see our [Model overview](/docs/models) for descriptions of them.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * The number of dimensions the resulting output embeddings should have. Only supported in `text-embedding-3` and later models.
     */
    #[Optional]
    public ?int $dimensions;

    /**
     * The format to return the embeddings in. Can be either `float` or [`base64`](https://pypi.org/project/pybase64/).
     *
     * @var value-of<EncodingFormat>|null $encodingFormat
     */
    #[Optional('encoding_format', enum: EncodingFormat::class)]
    public ?string $encodingFormat;

    /**
     * A unique identifier representing your end-user, which can help OpenAI to monitor and detect abuse. [Learn more](/docs/guides/safety-best-practices#end-user-ids).
     */
    #[Optional]
    public ?string $user;

    /**
     * `new CreateEmbeddingRequest()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreateEmbeddingRequest::with(input: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreateEmbeddingRequest)->withInput(...)->withModel(...)
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
     * @param InputShape $input
     * @param string|Model|value-of<Model> $model
     * @param EncodingFormat|value-of<EncodingFormat>|null $encodingFormat
     */
    public static function with(
        string|array $input,
        Model|string $model,
        ?int $dimensions = null,
        EncodingFormat|string|null $encodingFormat = null,
        ?string $user = null,
    ): self {
        $self = new self;

        $self['input'] = $input;
        $self['model'] = $model;

        null !== $dimensions && $self['dimensions'] = $dimensions;
        null !== $encodingFormat && $self['encodingFormat'] = $encodingFormat;
        null !== $user && $self['user'] = $user;

        return $self;
    }

    /**
     * Input text to embed, encoded as a string or array of tokens. To embed multiple inputs in a single request, pass an array of strings or array of token arrays. The input must not exceed the max input tokens for the model (8192 tokens for all embedding models), cannot be an empty string, and any array must be 2048 dimensions or less. [Example Python code](https://cookbook.openai.com/examples/how_to_count_tokens_with_tiktoken) for counting tokens. In addition to the per-input token limit, all embedding  models enforce a maximum of 300,000 tokens summed across all inputs in a  single request.
     *
     * @param InputShape $input
     */
    public function withInput(string|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * ID of the model to use. You can use the [List models](/docs/api-reference/models/list) API to see all of your available models, or see our [Model overview](/docs/models) for descriptions of them.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The number of dimensions the resulting output embeddings should have. Only supported in `text-embedding-3` and later models.
     */
    public function withDimensions(int $dimensions): self
    {
        $self = clone $this;
        $self['dimensions'] = $dimensions;

        return $self;
    }

    /**
     * The format to return the embeddings in. Can be either `float` or [`base64`](https://pypi.org/project/pybase64/).
     *
     * @param EncodingFormat|value-of<EncodingFormat> $encodingFormat
     */
    public function withEncodingFormat(
        EncodingFormat|string $encodingFormat
    ): self {
        $self = clone $this;
        $self['encodingFormat'] = $encodingFormat;

        return $self;
    }

    /**
     * A unique identifier representing your end-user, which can help OpenAI to monitor and detect abuse. [Learn more](/docs/guides/safety-best-practices#end-user-ids).
     */
    public function withUser(string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }
}
