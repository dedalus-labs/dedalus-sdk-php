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
 * Edit images using inpainting.
 *
 * Supports dall-e-2 and gpt-image-1. Upload an image and optionally a mask
 * to indicate which areas to regenerate based on the prompt.
 *
 * @see DedalusSDK\Services\ImagesService::edit()
 *
 * @phpstan-type ImageEditParamsShape = array{
 *   image: string|FileParam,
 *   prompt: string,
 *   mask?: string|null|FileParam,
 *   model?: string|null,
 *   n?: int|null,
 *   responseFormat?: string|null,
 *   size?: string|null,
 *   user?: string|null,
 * }
 */
final class ImageEditParams implements BaseModel
{
    /** @use SdkModel<ImageEditParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $image;

    #[Required]
    public string $prompt;

    #[Optional(nullable: true)]
    public ?string $mask;

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
     * `new ImageEditParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageEditParams::with(image: ..., prompt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageEditParams)->withImage(...)->withPrompt(...)
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
        string $prompt,
        string|FileParam|null $mask = null,
        ?string $model = null,
        ?int $n = null,
        ?string $responseFormat = null,
        ?string $size = null,
        ?string $user = null,
    ): self {
        $self = new self;

        $self['image'] = $image;
        $self['prompt'] = $prompt;

        null !== $mask && $self['mask'] = $mask;
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

    public function withPrompt(string $prompt): self
    {
        $self = clone $this;
        $self['prompt'] = $prompt;

        return $self;
    }

    public function withMask(string|FileParam|null $mask): self
    {
        $self = clone $this;
        $self['mask'] = $mask;

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
