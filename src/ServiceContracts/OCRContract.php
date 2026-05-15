<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\OCR\OCRDocument;
use DedalusSDK\OCR\OCRResponse;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type OCRDocumentShape from \DedalusSDK\OCR\OCRDocument
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface OCRContract
{
    /**
     * @api
     *
     * @param OCRDocument|OCRDocumentShape $document document input for OCR
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function process(
        OCRDocument|array $document,
        string $model = 'mistral-ocr-latest',
        RequestOptions|array|null $requestOptions = null,
    ): OCRResponse;
}
