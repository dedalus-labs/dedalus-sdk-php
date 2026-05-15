<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\PredictionContent\Content;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Static predicted output content, such as the content of a text file that is
 * being regenerated.
 *
 * Fields:
 * - type (required): Literal["content"]
 * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("PredictionContentArray")]
 *
 * @phpstan-import-type ContentVariants from \DedalusSDK\Chat\Completions\PredictionContent\Content
 * @phpstan-import-type ContentShape from \DedalusSDK\Chat\Completions\PredictionContent\Content
 *
 * @phpstan-type PredictionContentShape = array{
 *   content: ContentShape, type: 'content'
 * }
 */
final class PredictionContent implements BaseModel
{
    /** @use SdkModel<PredictionContentShape> */
    use SdkModel;

    /**
     * The type of the predicted content you want to provide. This type is
     * currently always `content`.
     *
     * @var 'content' $type
     */
    #[Required]
    public string $type = 'content';

    /**
     * The content that should be matched when generating a model response.
     * If generated tokens would match this content, the entire model response
     * can be returned much more quickly.
     *
     * @var ContentVariants $content
     */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * `new PredictionContent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PredictionContent::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PredictionContent)->withContent(...)
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
    public static function with(string|array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * The content that should be matched when generating a model response.
     * If generated tokens would match this content, the entire model response
     * can be returned much more quickly.
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
     * The type of the predicted content you want to provide. This type is
     * currently always `content`.
     *
     * @param 'content' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
