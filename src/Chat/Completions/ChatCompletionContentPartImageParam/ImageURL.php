<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam\ImageURL\Detail;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ImageUrl.
 *
 * Fields:
 * - url (required): AnyUrl
 * - detail (optional): Literal["auto", "low", "high"]
 *
 * @phpstan-type ImageURLShape = array{
 *   url: string, detail?: null|Detail|value-of<Detail>
 * }
 */
final class ImageURL implements BaseModel
{
    /** @use SdkModel<ImageURLShape> */
    use SdkModel;

    /**
     * Either a URL of the image or the base64 encoded image data.
     */
    #[Required]
    public string $url;

    /**
     * Specifies the detail level of the image. Learn more in the [Vision guide](/docs/guides/vision#low-or-high-fidelity-image-understanding).
     *
     * @var value-of<Detail>|null $detail
     */
    #[Optional(enum: Detail::class)]
    public ?string $detail;

    /**
     * `new ImageURL()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageURL::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageURL)->withURL(...)
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
     * @param Detail|value-of<Detail>|null $detail
     */
    public static function with(string $url, Detail|string|null $detail = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $detail && $self['detail'] = $detail;

        return $self;
    }

    /**
     * Either a URL of the image or the base64 encoded image data.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Specifies the detail level of the image. Learn more in the [Vision guide](/docs/guides/vision#low-or-high-fidelity-image-understanding).
     *
     * @param Detail|value-of<Detail> $detail
     */
    public function withDetail(Detail|string $detail): self
    {
        $self = clone $this;
        $self['detail'] = $detail;

        return $self;
    }
}
