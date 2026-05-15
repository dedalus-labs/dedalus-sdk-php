<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for File.
 *
 * Fields:
 * - filename (optional): str
 * - file_data (optional): str
 * - file_id (optional): str
 *
 * @phpstan-type FileShape = array{
 *   fileData?: string|null, fileID?: string|null, filename?: string|null
 * }
 */
final class File implements BaseModel
{
    /** @use SdkModel<FileShape> */
    use SdkModel;

    /**
     * The base64 encoded file data, used when passing the file to the model
     * as a string.
     */
    #[Optional('file_data')]
    public ?string $fileData;

    /**
     * The ID of an uploaded file to use as input.
     */
    #[Optional('file_id')]
    public ?string $fileID;

    /**
     * The name of the file, used when passing the file to the model as a
     * string.
     */
    #[Optional]
    public ?string $filename;

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
        ?string $fileData = null,
        ?string $fileID = null,
        ?string $filename = null
    ): self {
        $self = new self;

        null !== $fileData && $self['fileData'] = $fileData;
        null !== $fileID && $self['fileID'] = $fileID;
        null !== $filename && $self['filename'] = $filename;

        return $self;
    }

    /**
     * The base64 encoded file data, used when passing the file to the model
     * as a string.
     */
    public function withFileData(string $fileData): self
    {
        $self = clone $this;
        $self['fileData'] = $fileData;

        return $self;
    }

    /**
     * The ID of an uploaded file to use as input.
     */
    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    /**
     * The name of the file, used when passing the file to the model as a
     * string.
     */
    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }
}
