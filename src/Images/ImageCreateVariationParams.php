<?php

declare(strict_types=1);

namespace DedalusSDK\Images;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\FileParam;

/**
 * Create variations of an image.
 *
 * DALL·E 2 only. Upload an image to generate variations.
 *
 * @see DedalusSDK\Services\ImagesService::createVariation()
 *
 * @phpstan-type ImageCreateVariationParamsShape = array{
 *   image: string|FileParam,
 *   model?: string|null,
 *   n?: int|null,
 *   responseFormat?: string|null,
 *   size?: string|null,
 *   user?: string|null,
 * }
 */
final class ImageCreateVariationParams implements BaseModel
{
    /** @use SdkModel<ImageCreateVariationParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $image;

    #[Optional(nullable: true)]
    public ?string $model;

    #[Optional(nullable: true)]
    public ?int $n;

    #[Optional('response_format', nullable: true)]
    public ?string $responseFormat;

    #[Optional(nullable: true)]
    public ?string $size;

    #[Optional(nullable: true)]
    public ?string $user;

    /**
     * `new ImageCreateVariationParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageCreateVariationParams::with(image: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageCreateVariationParams)->withImage(...)
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
     */
    public static function with(
        string|FileParam $image,
        ?string $model = null,
        ?int $n = null,
        ?string $responseFormat = null,
        ?string $size = null,
        ?string $user = null,
    ): self {
        $self = new self;

        $self['image'] = $image;

        null !== $model && $self['model'] = $model;
        null !== $n && $self['n'] = $n;
        null !== $responseFormat && $self['responseFormat'] = $responseFormat;
        null !== $size && $self['size'] = $size;
        null !== $user && $self['user'] = $user;

        return $self;
    }

    public function withImage(string|FileParam $image): self
    {
        $self = clone $this;
        $self['image'] = $image;

        return $self;
    }

    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    public function withN(?int $n): self
    {
        $self = clone $this;
        $self['n'] = $n;

        return $self;
    }

    public function withResponseFormat(?string $responseFormat): self
    {
        $self = clone $this;
        $self['responseFormat'] = $responseFormat;

        return $self;
    }

    public function withSize(?string $size): self
    {
        $self = clone $this;
        $self['size'] = $size;

        return $self;
    }

    public function withUser(?string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }
}
