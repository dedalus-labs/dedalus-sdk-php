<?php

declare(strict_types=1);

namespace DedalusSDK\Images;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Response from image generation.
 *
 * @phpstan-import-type ImageShape from \DedalusSDK\Images\Image
 *
 * @phpstan-type ImagesResponseShape = array{
 *   created: int, data: list<Image|ImageShape>
 * }
 */
final class ImagesResponse implements BaseModel
{
    /** @use SdkModel<ImagesResponseShape> */
    use SdkModel;

    /**
     * Unix timestamp when images were created.
     */
    #[Required]
    public int $created;

    /**
     * List of generated images.
     *
     * @var list<Image> $data
     */
    #[Required(list: Image::class)]
    public array $data;

    /**
     * `new ImagesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImagesResponse::with(created: ..., data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImagesResponse)->withCreated(...)->withData(...)
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
     * @param list<Image|ImageShape> $data
     */
    public static function with(int $created, array $data): self
    {
        $self = new self;

        $self['created'] = $created;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Unix timestamp when images were created.
     */
    public function withCreated(int $created): self
    {
        $self = clone $this;
        $self['created'] = $created;

        return $self;
    }

    /**
     * List of generated images.
     *
     * @param list<Image|ImageShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }
}
