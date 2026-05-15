<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Messages sent by an end user, containing prompts or additional context
 * information.
 *
 * Fields:
 * - content (required): str | Annotated[list[ChatCompletionRequestUserMessageContentPart], MinLen(1), ArrayTitle("ChatCompletionRequestUserMessageContentArray")]
 * - role (required): Literal["user"]
 * - name (optional): str
 *
 * @phpstan-import-type ContentVariants from \DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content
 * @phpstan-import-type ContentShape from \DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content
 *
 * @phpstan-type ChatCompletionUserMessageParamShape = array{
 *   content: ContentShape, role: 'user', name?: string|null
 * }
 */
final class ChatCompletionUserMessageParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionUserMessageParamShape> */
    use SdkModel;

    /**
     * The role of the messages author, in this case `user`.
     *
     * @var 'user' $role
     */
    #[Required]
    public string $role = 'user';

    /**
     * The contents of the user message.
     *
     * @var ContentVariants $content
     */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * An optional name for the participant. Provides the model information to differentiate between participants of the same role.
     */
    #[Optional]
    public ?string $name;

    /**
     * `new ChatCompletionUserMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionUserMessageParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionUserMessageParam)->withContent(...)
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
    public static function with(
        string|array $content,
        ?string $name = null
    ): self {
        $self = new self;

        $self['content'] = $content;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * The contents of the user message.
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
     * The role of the messages author, in this case `user`.
     *
     * @param 'user' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * An optional name for the participant. Provides the model information to differentiate between participants of the same role.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
