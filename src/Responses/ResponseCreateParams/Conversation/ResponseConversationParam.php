<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams\Conversation;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Conversation reference for continuing a Responses session.
 *
 * @phpstan-type ResponseConversationParamShape = array{id: string}
 */
final class ResponseConversationParam implements BaseModel
{
    /** @use SdkModel<ResponseConversationParamShape> */
    use SdkModel;

    /**
     * Identifier of the existing conversation.
     */
    #[Required]
    public string $id;

    /**
     * `new ResponseConversationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ResponseConversationParam::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ResponseConversationParam)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * Identifier of the existing conversation.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
