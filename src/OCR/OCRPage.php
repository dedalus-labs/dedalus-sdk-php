<?php

declare(strict_types=1);

namespace DedalusSDK\OCR;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Single page OCR result.
 *
 * @phpstan-type OCRPageShape = array{index: int, markdown: string}
 */
final class OCRPage implements BaseModel
{
    /** @use SdkModel<OCRPageShape> */
    use SdkModel;

    #[Required]
    public int $index;

    #[Required]
    public string $markdown;

    /**
     * `new OCRPage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OCRPage::with(index: ..., markdown: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OCRPage)->withIndex(...)->withMarkdown(...)
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
    public static function with(int $index, string $markdown): self
    {
        $self = new self;

        $self['index'] = $index;
        $self['markdown'] = $markdown;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }

    public function withMarkdown(string $markdown): self
    {
        $self = clone $this;
        $self['markdown'] = $markdown;

        return $self;
    }
}
