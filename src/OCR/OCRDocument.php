<?php

declare(strict_types=1);

namespace DedalusSDK\OCR;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Document input for OCR.
 *
 * @phpstan-type OCRDocumentShape = array{documentURL: string, type?: string|null}
 */
final class OCRDocument implements BaseModel
{
    /** @use SdkModel<OCRDocumentShape> */
    use SdkModel;

    /**
     * Data URI with base64-encoded document.
     */
    #[Required('document_url')]
    public string $documentURL;

    #[Optional]
    public ?string $type;

    /**
     * `new OCRDocument()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OCRDocument::with(documentURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OCRDocument)->withDocumentURL(...)
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
    public static function with(string $documentURL, ?string $type = null): self
    {
        $self = new self;

        $self['documentURL'] = $documentURL;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Data URI with base64-encoded document.
     */
    public function withDocumentURL(string $documentURL): self
    {
        $self = clone $this;
        $self['documentURL'] = $documentURL;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
