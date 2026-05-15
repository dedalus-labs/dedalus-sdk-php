<?php

declare(strict_types=1);

namespace DedalusSDK\Models;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Models\ListModelsResponse\Object_;

/**
 * Response for /v1/models endpoint.
 *
 * @phpstan-import-type ModelShape from \DedalusSDK\Models\Model
 *
 * @phpstan-type ListModelsResponseShape = array{
 *   data: list<Model|ModelShape>, object?: null|Object_|value-of<Object_>
 * }
 */
final class ListModelsResponse implements BaseModel
{
    /** @use SdkModel<ListModelsResponseShape> */
    use SdkModel;

    /**
     * List of available models.
     *
     * @var list<Model> $data
     */
    #[Required(list: Model::class)]
    public array $data;

    /**
     * Response object type.
     *
     * @var value-of<Object_>|null $object
     */
    #[Optional(enum: Object_::class)]
    public ?string $object;

    /**
     * `new ListModelsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ListModelsResponse::with(data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ListModelsResponse)->withData(...)
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
     * @param list<Model|ModelShape> $data
     * @param Object_|value-of<Object_>|null $object
     */
    public static function with(
        array $data,
        Object_|string|null $object = null
    ): self {
        $self = new self;

        $self['data'] = $data;

        null !== $object && $self['object'] = $object;

        return $self;
    }

    /**
     * List of available models.
     *
     * @param list<Model|ModelShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Response object type.
     *
     * @param Object_|value-of<Object_> $object
     */
    public function withObject(Object_|string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }
}
