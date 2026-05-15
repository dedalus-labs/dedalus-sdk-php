<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Translations\TranslationNewResponse;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Fields:  # noqa: D415.
 *
 * - text (required): str
 *
 * @phpstan-type CreateTranslationResponseJSONShape = array{text: string}
 */
final class CreateTranslationResponseJSON implements BaseModel
{
    /** @use SdkModel<CreateTranslationResponseJSONShape> */
    use SdkModel;

    #[Required]
    public string $text;

    /**
     * `new CreateTranslationResponseJSON()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreateTranslationResponseJSON::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreateTranslationResponseJSON)->withText(...)
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
    public static function with(string $text): self
    {
        $self = new self;

        $self['text'] = $text;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
