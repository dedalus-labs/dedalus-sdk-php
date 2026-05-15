<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionSystemMessageParam\Content;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Developer-provided instructions that the model should follow, regardless of
 * messages sent by the user. With o1 models and newer, use `developer` messages
 * for this purpose instead.
 *
 * Fields:
 * - content (required): str | Annotated[list[ChatCompletionRequestSystemMessageContentPart], MinLen(1), ArrayTitle("ChatCompletionRequestSystemMessageContentArray")]
 * - role (required): Literal["system"]
 * - name (optional): str
 *
 * @phpstan-import-type ContentVariants from \DedalusSDK\Chat\Completions\ChatCompletionSystemMessageParam\Content
 * @phpstan-import-type ContentShape from \DedalusSDK\Chat\Completions\ChatCompletionSystemMessageParam\Content
 *
 * @phpstan-type ChatCompletionSystemMessageParamShape = array{
 *   content: ContentShape, role: 'system', name?: string|null
 * }
 */
final class ChatCompletionSystemMessageParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionSystemMessageParamShape> */
    use SdkModel;

    /**
     * The role of the messages author, in this case `system`.
     *
     * @var 'system' $role
     */
    #[Required]
    public string $role = 'system';

    /**
     * The contents of the system message.
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
     * `new ChatCompletionSystemMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionSystemMessageParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionSystemMessageParam)->withContent(...)
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
     * The contents of the system message.
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
     * The role of the messages author, in this case `system`.
     *
     * @param 'system' $role
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
