<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams1;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Responses\ResponseCreateParams1\Conversation\ResponseConversationParam;

/**
 * Conversation that this response belongs to. Items from this conversation are prepended to the input items, and output items from this response are automatically added after completion.
 *
 * @phpstan-import-type ResponseConversationParamShape from \DedalusSDK\Responses\ResponseCreateParams1\Conversation\ResponseConversationParam
 *
 * @phpstan-type ConversationVariants = string|ResponseConversationParam
 * @phpstan-type ConversationShape = ConversationVariants|ResponseConversationParamShape
 */
final class Conversation implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', ResponseConversationParam::class];
    }
}
