<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\Util;
use DedalusSDK\OCR\OCRDocument;
use DedalusSDK\OCR\OCRResponse;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\OCRContract;

/**
 * @phpstan-import-type OCRDocumentShape from \DedalusSDK\OCR\OCRDocument
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class OCRService implements OCRContract
{
    /**
     * @api
     */
    public OCRRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new OCRRawService($client);
    }

    /**
     * @api
     *
     * Process a document through Mistral OCR.
     *
     * Extracts text from PDFs and images, returning markdown-formatted content.
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
    ): OCRResponse {
        $params = Util::removeNulls(['document' => $document, 'model' => $model]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->process(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
