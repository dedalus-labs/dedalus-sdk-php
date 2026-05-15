<?php

namespace Tests\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\FileParam;
use DedalusSDK\Core\Util;
use DedalusSDK\Images\ImagesResponse;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class ImagesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreateVariation(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->createVariation(
            image: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }

    #[Test]
    public function testCreateVariationWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->createVariation(
            image: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            model: 'model',
            n: 0,
            responseFormat: 'response_format',
            size: 'size',
            user: 'user',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }

    #[Test]
    public function testEdit(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->edit(
            image: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            prompt: 'prompt',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }

    #[Test]
    public function testEditWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->edit(
            image: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            prompt: 'prompt',
            mask: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            model: 'model',
            n: 0,
            responseFormat: 'response_format',
            size: 'size',
            user: 'user',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }

    #[Test]
    public function testGenerate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->generate(prompt: 'A white siamese cat');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }

    #[Test]
    public function testGenerateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->images->generate(
            prompt: 'A white siamese cat',
            background: 'transparent',
            model: 'openai/dall-e-3',
            moderation: 'auto',
            n: 1,
            outputCompression: 85,
            outputFormat: 'png',
            partialImages: 0,
            quality: 'standard',
            responseFormat: 'url',
            size: '1024x1024',
            stream: true,
            style: 'vivid',
            user: 'user',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ImagesResponse::class, $result);
    }
}
