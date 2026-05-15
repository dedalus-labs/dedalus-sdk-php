<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionToolMessageParam\Content;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ChatCompletionRequestToolMessage.
 *
 * Fields:
 * - role (required): Literal["tool"]
 * - content (required): str | Annotated[list[ChatCompletionRequestToolMessageContentPart], MinLen(1), ArrayTitle("ChatCompletionRequestToolMessageContentArray")]
 * - tool_call_id (required): str
 *
 * @phpstan-import-type ContentVariants from \DedalusSDK\Chat\Completions\ChatCompletionToolMessageParam\Content
 * @phpstan-import-type ContentShape from \DedalusSDK\Chat\Completions\ChatCompletionToolMessageParam\Content
 *
 * @phpstan-type ChatCompletionToolMessageParamShape = array{
 *   content: ContentShape, role: 'tool', toolCallID: string
 * }
 */
final class ChatCompletionToolMessageParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionToolMessageParamShape> */
    use SdkModel;

    /**
     * The role of the messages author, in this case `tool`.
     *
     * @var 'tool' $role
     */
    #[Required]
    public string $role = 'tool';

    /**
     * The contents of the tool message.
     *
     * @var ContentVariants $content
     */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * Tool call that this message is responding to.
     */
    #[Required('tool_call_id')]
    public string $toolCallID;

    /**
     * `new ChatCompletionToolMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionToolMessageParam::with(content: ..., toolCallID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionToolMessageParam)->withContent(...)->withToolCallID(...)
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
     * @param ContentShape $content
     */
    public static function with(string|array $content, string $toolCallID): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['toolCallID'] = $toolCallID;

        return $self;
    }

    /**
     * The contents of the tool message.
     *
     * @param ContentShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * The role of the messages author, in this case `tool`.
     *
     * @param 'tool' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Tool call that this message is responding to.
     */
    public function withToolCallID(string $toolCallID): self
    {
        $self = clone $this;
        $self['toolCallID'] = $toolCallID;

        return $self;
    }
}
