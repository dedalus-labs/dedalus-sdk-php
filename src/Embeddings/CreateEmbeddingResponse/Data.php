<?php

declare(strict_types=1);

namespace DedalusSDK\Embeddings\CreateEmbeddingResponse;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Represents an embedding vector returned by embedding endpoint.
 *
 * Fields:
 * - index (required): int
 * - embedding (required): list[float]
 * - object (required): Literal["embedding"]
 *
 * @phpstan-type DataShape = array{
 *   embedding: list<float>, index: int, object: 'embedding'
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * The object type, which is always "embedding".
     *
     * @var 'embedding' $object
     */
    #[Required]
    public string $object = 'embedding';

    /**
     * The embedding vector, which is a list of floats. The length of vector depends on the model as listed in the [embedding guide](/docs/guides/embeddings).
     *
     * @var list<float> $embedding
     */
    #[Required(list: 'float')]
    public array $embedding;

    /**
     * The index of the embedding in the list of embeddings.
     */
    #[Required]
    public int $index;

    /**
     * `new Data()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Data::with(embedding: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Data)->withEmbedding(...)->withIndex(...)
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
     * @param list<float> $embedding
     */
    public static function with(array $embedding, int $index): self
    {
        $self = new self;

        $self['embedding'] = $embedding;
        $self['index'] = $index;

        return $self;
    }

    /**
     * The embedding vector, which is a list of floats. The length of vector depends on the model as listed in the [embedding guide](/docs/guides/embeddings).
     *
     * @param list<float> $embedding
     */
    public function withEmbedding(array $embedding): self
    {
        $self = clone $this;
        $self['embedding'] = $embedding;

        return $self;
    }

    /**
     * The index of the embedding in the list of embeddings.
     */
    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }

    /**
     * The object type, which is always "embedding".
     *
     * @param 'embedding' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }
}
