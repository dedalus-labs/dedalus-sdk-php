<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\FileParam;
use DedalusSDK\Images\ImageCreateVariationParams;
use DedalusSDK\Images\ImageEditParams;
use DedalusSDK\Images\ImageGenerateParams;
use DedalusSDK\Images\ImageGenerateParams\Background;
use DedalusSDK\Images\ImageGenerateParams\Moderation;
use DedalusSDK\Images\ImageGenerateParams\OutputFormat;
use DedalusSDK\Images\ImageGenerateParams\Quality;
use DedalusSDK\Images\ImageGenerateParams\ResponseFormat;
use DedalusSDK\Images\ImageGenerateParams\Size;
use DedalusSDK\Images\ImageGenerateParams\Style;
use DedalusSDK\Images\ImagesResponse;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\ImagesRawContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class ImagesRawService implements ImagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create variations of an image.
     *
     * DALL·E 2 only. Upload an image to generate variations.
     *
     * @param array{
     *   image: string|FileParam,
     *   model?: string|null,
     *   n?: int|null,
     *   responseFormat?: string|null,
     *   size?: string|null,
     *   user?: string|null,
     * }|ImageCreateVariationParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function createVariation(
        array|ImageCreateVariationParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ImageCreateVariationParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/images/variations',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ImagesResponse::class,
        );
    }

    /**
     * @api
     *
     * Edit images using inpainting.
     *
     * Supports dall-e-2 and gpt-image-1. Upload an image and optionally a mask
     * to indicate which areas to regenerate based on the prompt.
     *
     * @param array{
     *   image: string|FileParam,
     *   prompt: string,
     *   mask?: string|FileParam|null,
     *   model?: string|null,
     *   n?: int|null,
     *   responseFormat?: string|null,
     *   size?: string|null,
     *   user?: string|null,
     * }|ImageEditParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function edit(
        array|ImageEditParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ImageEditParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/images/edits',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ImagesResponse::class,
        );
    }

    /**
     * @api
     *
     * Generate images from text prompts.
     *
     * Pure image generation models only (DALL-E, GPT Image).
     * For multimodal models like gemini-2.5-flash-image, use /v1/chat/completions.
     *
     * @param array{
     *   prompt: string,
     *   background?: Background|value-of<Background>|null,
     *   model?: string|null,
     *   moderation?: Moderation|value-of<Moderation>|null,
     *   n?: int|null,
     *   outputCompression?: int|null,
     *   outputFormat?: OutputFormat|value-of<OutputFormat>|null,
     *   partialImages?: int|null,
     *   quality?: Quality|value-of<Quality>|null,
     *   responseFormat?: ResponseFormat|value-of<ResponseFormat>|null,
     *   size?: value-of<Size>,
     *   stream?: bool|null,
     *   style?: Style|value-of<Style>|null,
     *   user?: string|null,
     * }|ImageGenerateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ImagesResponse>
     *
     * @throws APIException
     */
    public function generate(
        array|ImageGenerateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ImageGenerateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/images/generations',
            body: (object) $parsed,
            options: $options,
            convert: ImagesResponse::class,
        );
    }
}
