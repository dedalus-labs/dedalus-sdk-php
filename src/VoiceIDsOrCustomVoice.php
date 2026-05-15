<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Custom voice reference.
 *
 * Fields:
 * - id (required): str
 *
 * @phpstan-type VoiceIDsOrCustomVoiceShape = array{id: string}
 */
final class VoiceIDsOrCustomVoice implements BaseModel
{
    /** @use SdkModel<VoiceIDsOrCustomVoiceShape> */
    use SdkModel;

    /**
     * The custom voice ID, e.g. `voice_1234`.
     */
    #[Required]
    public string $id;

    /**
     * `new VoiceIDsOrCustomVoice()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VoiceIDsOrCustomVoice::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VoiceIDsOrCustomVoice)->withID(...)
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
     * The custom voice ID, e.g. `voice_1234`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
