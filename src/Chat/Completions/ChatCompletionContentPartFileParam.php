<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam\File;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Learn about [file inputs](/docs/guides/text) for text generation.
 *
 * Fields:
 * - type (required): Literal["file"]
 * - file (required): File
 *
 * @phpstan-import-type FileShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam\File
 *
 * @phpstan-type ChatCompletionContentPartFileParamShape = array{
 *   file: File|FileShape, type: 'file'
 * }
 */
final class ChatCompletionContentPartFileParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionContentPartFileParamShape> */
    use SdkModel;

    /**
     * The type of the content part. Always `file`.
     *
     * @var 'file' $type
     */
    #[Required]
    public string $type = 'file';

    /**
     * Schema for File.
     *
     * Fields:
     * - filename (optional): str
     * - file_data (optional): str
     * - file_id (optional): str
     */
    #[Required]
    public File $file;

    /**
     * `new ChatCompletionContentPartFileParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionContentPartFileParam::with(file: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionContentPartFileParam)->withFile(...)
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
     * @param File|FileShape $file
     */
    public static function with(File|array $file): self
    {
        $self = new self;

        $self['file'] = $file;

        return $self;
    }

    /**
     * Schema for File.
     *
     * Fields:
     * - filename (optional): str
     * - file_data (optional): str
     * - file_id (optional): str
     *
     * @param File|FileShape $file
     */
    public function withFile(File|array $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    /**
     * The type of the content part. Always `file`.
     *
     * @param 'file' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
