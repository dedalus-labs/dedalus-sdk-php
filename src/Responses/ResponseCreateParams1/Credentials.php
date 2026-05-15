<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams1;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\Credential;

/**
 * Credentials for MCP server authentication. Each credential is matched to servers by connection name.
 *
 * @phpstan-import-type CredentialShape from \DedalusSDK\Credential
 *
 * @phpstan-type CredentialsVariants = Credential|list<Credential>
 * @phpstan-type CredentialsShape = CredentialsVariants|CredentialShape|list<CredentialShape>
 */
final class Credentials implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [Credential::class, new ListOf(Credential::class)];
    }
}
