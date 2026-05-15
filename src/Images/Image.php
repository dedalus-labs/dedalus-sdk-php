<?php

declare(strict_types=1);

namespace DedalusSDK\Images;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Single image object.
 *
 * @phpstan-type ImageShape = array{
 *   b64JSON?: string|null, revisedPrompt?: string|null, url?: string|null
 * }
 */
final class Image implements BaseModel
{
    /** @use SdkModel<ImageShape> */
    use SdkModel;

    /**
     * Base64-encoded image data (if response_format=b64_json).
     */
    #[Optional('b64_json', nullable: true)]
    public ?string $b64JSON;

    /**
     * Revised prompt used for generation (dall-e-3).
     */
    #[Optional('revised_prompt', nullable: true)]
    public ?string $revisedPrompt;

    /**
     * URL of the generated image (if response_format=url).
     */
    #[Optional(nullable: true)]
    public ?string $url;

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
        ?string $b64JSON = null,
        ?string $revisedPrompt = null,
        ?string $url = null
    ): self {
        $self = new self;

        null !== $b64JSON && $self['b64JSON'] = $b64JSON;
        null !== $revisedPrompt && $self['revisedPrompt'] = $revisedPrompt;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * Base64-encoded image data (if response_format=b64_json).
     */
    public function withB64JSON(?string $b64JSON): self
    {
        $self = clone $this;
        $self['b64JSON'] = $b64JSON;

        return $self;
    }

    /**
     * Revised prompt used for generation (dall-e-3).
     */
    public function withRevisedPrompt(?string $revisedPrompt): self
    {
        $self = clone $this;
        $self['revisedPrompt'] = $revisedPrompt;

        return $self;
    }

    /**
     * URL of the generated image (if response_format=url).
     */
    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
