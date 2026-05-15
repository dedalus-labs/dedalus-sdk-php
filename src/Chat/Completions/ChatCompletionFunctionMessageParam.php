<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ChatCompletionRequestFunctionMessage.
 *
 * Fields:
 * - role (required): Literal["function"]
 * - content (required): str | None
 * - name (required): str
 *
 * @phpstan-type ChatCompletionFunctionMessageParamShape = array{
 *   content: string|null, name: string, role: 'function'
 * }
 */
final class ChatCompletionFunctionMessageParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionFunctionMessageParamShape> */
    use SdkModel;

    /**
     * The role of the messages author, in this case `function`.
     *
     * @var 'function' $role
     */
    #[Required]
    public string $role = 'function';

    /**
     * The contents of the function message.
     */
    #[Required]
    public ?string $content;

    /**
     * The name of the function to call.
     */
    #[Required]
    public string $name;

    /**
     * `new ChatCompletionFunctionMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionFunctionMessageParam::with(content: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionFunctionMessageParam)->withContent(...)->withName(...)
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
    public static function with(?string $content, string $name): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The contents of the function message.
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * The name of the function to call.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The role of the messages author, in this case `function`.
     *
     * @param 'function' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
