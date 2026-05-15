<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam\ImageURL;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Learn about [image inputs](/docs/guides/vision).
 *
 * Fields:
 * - type (required): Literal["image_url"]
 * - image_url (required): ImageUrl
 *
 * @phpstan-import-type ImageURLShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam\ImageURL
 *
 * @phpstan-type ChatCompletionContentPartImageParamShape = array{
 *   imageURL: ImageURL|ImageURLShape, type: 'image_url'
 * }
 */
final class ChatCompletionContentPartImageParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionContentPartImageParamShape> */
    use SdkModel;

    /**
     * The type of the content part.
     *
     * @var 'image_url' $type
     */
    #[Required]
    public string $type = 'image_url';

    /**
     * Schema for ImageUrl.
     *
     * Fields:
     * - url (required): AnyUrl
     * - detail (optional): Literal["auto", "low", "high"]
     */
    #[Required('image_url')]
    public ImageURL $imageURL;

    /**
     * `new ChatCompletionContentPartImageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionContentPartImageParam::with(imageURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionContentPartImageParam)->withImageURL(...)
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
     * @param ImageURL|ImageURLShape $imageURL
     */
    public static function with(ImageURL|array $imageURL): self
    {
        $self = new self;

        $self['imageURL'] = $imageURL;

        return $self;
    }

    /**
     * Schema for ImageUrl.
     *
     * Fields:
     * - url (required): AnyUrl
     * - detail (optional): Literal["auto", "low", "high"]
     *
     * @param ImageURL|ImageURLShape $imageURL
     */
    public function withImageURL(ImageURL|array $imageURL): self
    {
        $self = clone $this;
        $self['imageURL'] = $imageURL;

        return $self;
    }

    /**
     * The type of the content part.
     *
     * @param 'image_url' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
