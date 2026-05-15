<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\MCPServerItem;
use DedalusSDK\MCPServerSpec;

/**
 * MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
 *
 * @phpstan-import-type MCPServerSpecShape from \DedalusSDK\MCPServerSpec
 * @phpstan-import-type MCPServerItemShape from \DedalusSDK\MCPServerItem
 *
 * @phpstan-type MCPServersVariants = string|MCPServerSpec|list<string|MCPServerSpec>
 * @phpstan-type MCPServersShape = MCPServersVariants|MCPServerSpecShape|list<MCPServerItemShape>
 */
final class MCPServers implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', MCPServerSpec::class, new ListOf(MCPServerItem::class)];
    }
}
