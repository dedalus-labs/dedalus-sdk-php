<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Data about a previous audio response from the model.
 * [Learn more](/docs/guides/audio).
 *
 * Fields:
 * - id (required): str
 *
 * @phpstan-type AudioShape = array{id: string}
 */
final class Audio implements BaseModel
{
    /** @use SdkModel<AudioShape> */
    use SdkModel;

    /**
     * Unique identifier for a previous audio response from the model.
     */
    #[Required]
    public string $id;

    /**
     * `new Audio()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Audio::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Audio)->withID(...)
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
     * Unique identifier for a previous audio response from the model.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
