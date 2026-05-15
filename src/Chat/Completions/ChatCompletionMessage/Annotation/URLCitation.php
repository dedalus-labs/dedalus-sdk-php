<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionMessage\Annotation;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * A URL citation when using web search.
 *
 * Fields:
 * - end_index (required): int
 * - start_index (required): int
 * - url (required): str
 * - title (required): str
 *
 * @phpstan-type URLCitationShape = array{
 *   endIndex: int, startIndex: int, title: string, url: string
 * }
 */
final class URLCitation implements BaseModel
{
    /** @use SdkModel<URLCitationShape> */
    use SdkModel;

    /**
     * The index of the last character of the URL citation in the message.
     */
    #[Required('end_index')]
    public int $endIndex;

    /**
     * The index of the first character of the URL citation in the message.
     */
    #[Required('start_index')]
    public int $startIndex;

    /**
     * The title of the web resource.
     */
    #[Required]
    public string $title;

    /**
     * The URL of the web resource.
     */
    #[Required]
    public string $url;

    /**
     * `new URLCitation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * URLCitation::with(endIndex: ..., startIndex: ..., title: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new URLCitation)
     *   ->withEndIndex(...)
     *   ->withStartIndex(...)
     *   ->withTitle(...)
     *   ->withURL(...)
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
    public static function with(
        int $endIndex,
        int $startIndex,
        string $title,
        string $url
    ): self {
        $self = new self;

        $self['endIndex'] = $endIndex;
        $self['startIndex'] = $startIndex;
        $self['title'] = $title;
        $self['url'] = $url;

        return $self;
    }

    /**
     * The index of the last character of the URL citation in the message.
     */
    public function withEndIndex(int $endIndex): self
    {
        $self = clone $this;
        $self['endIndex'] = $endIndex;

        return $self;
    }

    /**
     * The index of the first character of the URL citation in the message.
     */
    public function withStartIndex(int $startIndex): self
    {
        $self = clone $this;
        $self['startIndex'] = $startIndex;

        return $self;
    }

    /**
     * The title of the web resource.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * The URL of the web resource.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
