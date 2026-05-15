<?php

declare(strict_types=1);

namespace DedalusSDK\OCR;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Process a document through Mistral OCR.
 *
 * Extracts text from PDFs and images, returning markdown-formatted content.
 *
 * @see DedalusSDK\Services\OCRService::process()
 *
 * @phpstan-import-type OCRDocumentShape from \DedalusSDK\OCR\OCRDocument
 *
 * @phpstan-type OCRProcessParamsShape = array{
 *   document: OCRDocument|OCRDocumentShape, model?: string|null
 * }
 */
final class OCRProcessParams implements BaseModel
{
    /** @use SdkModel<OCRProcessParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Document input for OCR.
     */
    #[Required]
    public OCRDocument $document;

    #[Optional]
    public ?string $model;

    /**
     * `new OCRProcessParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OCRProcessParams::with(document: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OCRProcessParams)->withDocument(...)
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
     * @param OCRDocument|OCRDocumentShape $document
     */
    public static function with(
        OCRDocument|array $document,
        ?string $model = null
    ): self {
        $self = new self;

        $self['document'] = $document;

        null !== $model && $self['model'] = $model;

        return $self;
    }

    /**
     * Document input for OCR.
     *
     * @param OCRDocument|OCRDocumentShape $document
     */
    public function withDocument(OCRDocument|array $document): self
    {
        $self = clone $this;
        $self['document'] = $document;

        return $self;
    }

    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }
}
