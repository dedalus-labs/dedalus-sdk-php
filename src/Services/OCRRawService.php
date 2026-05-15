<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\OCR\OCRDocument;
use DedalusSDK\OCR\OCRProcessParams;
use DedalusSDK\OCR\OCRResponse;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\OCRRawContract;

/**
 * @phpstan-import-type OCRDocumentShape from \DedalusSDK\OCR\OCRDocument
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class OCRRawService implements OCRRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Process a document through Mistral OCR.
     *
     * Extracts text from PDFs and images, returning markdown-formatted content.
     *
     * @param array{
     *   document: OCRDocument|OCRDocumentShape, model?: string
     * }|OCRProcessParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OCRResponse>
     *
     * @throws APIException
     */
    public function process(
        array|OCRProcessParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = OCRProcessParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/ocr',
            body: (object) $parsed,
            options: $options,
            convert: OCRResponse::class,
        );
    }
}
