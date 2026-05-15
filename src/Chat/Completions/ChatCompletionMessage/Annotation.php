<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionMessage;

use DedalusSDK\Chat\Completions\ChatCompletionMessage\Annotation\URLCitation;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * A URL citation when using web search.
 *
 * Fields:
 * - type (required): Literal["url_citation"]
 * - url_citation (required): UrlCitation
 *
 * @phpstan-import-type URLCitationShape from \DedalusSDK\Chat\Completions\ChatCompletionMessage\Annotation\URLCitation
 *
 * @phpstan-type AnnotationShape = array{
 *   type: 'url_citation', urlCitation: URLCitation|URLCitationShape
 * }
 */
final class Annotation implements BaseModel
{
    /** @use SdkModel<AnnotationShape> */
    use SdkModel;

    /**
     * The type of the URL citation. Always `url_citation`.
     *
     * @var 'url_citation' $type
     */
    #[Required]
    public string $type = 'url_citation';

    /**
     * A URL citation when using web search.
     *
     * Fields:
     * - end_index (required): int
     * - start_index (required): int
     * - url (required): str
     * - title (required): str
     */
    #[Required('url_citation')]
    public URLCitation $urlCitation;

    /**
     * `new Annotation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Annotation::with(urlCitation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Annotation)->withURLCitation(...)
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
     * @param URLCitation|URLCitationShape $urlCitation
     */
    public static function with(URLCitation|array $urlCitation): self
    {
        $self = new self;

        $self['urlCitation'] = $urlCitation;

        return $self;
    }

    /**
     * The type of the URL citation. Always `url_citation`.
     *
     * @param 'url_citation' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A URL citation when using web search.
     *
     * Fields:
     * - end_index (required): int
     * - start_index (required): int
     * - url (required): str
     * - title (required): str
     *
     * @param URLCitation|URLCitationShape $urlCitation
     */
    public function withURLCitation(URLCitation|array $urlCitation): self
    {
        $self = clone $this;
        $self['urlCitation'] = $urlCitation;

        return $self;
    }
}
