<?php

declare(strict_types=1);

namespace DedalusSDK\OCR;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * OCR response schema.
 *
 * @phpstan-import-type OCRPageShape from \DedalusSDK\OCR\OCRPage
 *
 * @phpstan-type OCRResponseShape = array{
 *   model: string,
 *   pages: list<OCRPage|OCRPageShape>,
 *   usage?: array<string,mixed>|null,
 * }
 */
final class OCRResponse implements BaseModel
{
    /** @use SdkModel<OCRResponseShape> */
    use SdkModel;

    #[Required]
    public string $model;

    /** @var list<OCRPage> $pages */
    #[Required(list: OCRPage::class)]
    public array $pages;

    /** @var array<string,mixed>|null $usage */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $usage;

    /**
     * `new OCRResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OCRResponse::with(model: ..., pages: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OCRResponse)->withModel(...)->withPages(...)
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
     * @param list<OCRPage|OCRPageShape> $pages
     * @param array<string,mixed>|null $usage
     */
    public static function with(
        string $model,
        array $pages,
        ?array $usage = null
    ): self {
        $self = new self;

        $self['model'] = $model;
        $self['pages'] = $pages;

        null !== $usage && $self['usage'] = $usage;

        return $self;
    }

    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * @param list<OCRPage|OCRPageShape> $pages
     */
    public function withPages(array $pages): self
    {
        $self = clone $this;
        $self['pages'] = $pages;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $usage
     */
    public function withUsage(?array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
