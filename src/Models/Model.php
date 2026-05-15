<?php

declare(strict_types=1);

namespace DedalusSDK\Models;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Models\Model\Capabilities;
use DedalusSDK\Models\Model\Defaults;
use DedalusSDK\Models\Model\Provider;

/**
 * Unified model metadata across all providers.
 *
 * Combines provider-specific schemas into a single, consistent format.
 * Fields that aren't available from a provider are set to None.
 *
 * @phpstan-import-type CapabilitiesShape from \DedalusSDK\Models\Model\Capabilities
 * @phpstan-import-type DefaultsShape from \DedalusSDK\Models\Model\Defaults
 *
 * @phpstan-type ModelShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   provider: Provider|value-of<Provider>,
 *   capabilities?: null|Capabilities|CapabilitiesShape,
 *   defaults?: null|Defaults|DefaultsShape,
 *   description?: string|null,
 *   displayName?: string|null,
 *   providerDeclaredGenerationMethods?: list<string>|null,
 *   providerInfo?: array<string,mixed>|null,
 *   version?: string|null,
 * }
 */
final class Model implements BaseModel
{
    /** @use SdkModel<ModelShape> */
    use SdkModel;

    /**
     * Unique model identifier with provider prefix (e.g., 'openai/gpt-4').
     */
    #[Required]
    public string $id;

    /**
     * When the model was released (RFC 3339).
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Provider that hosts this model.
     *
     * @var value-of<Provider> $provider
     */
    #[Required(enum: Provider::class)]
    public string $provider;

    /**
     * Normalized model capabilities across all providers.
     */
    #[Optional(nullable: true)]
    public ?Capabilities $capabilities;

    /**
     * Provider-declared default parameters for model generation.
     */
    #[Optional(nullable: true)]
    public ?Defaults $defaults;

    /**
     * Model description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Human-readable model name.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Provider-specific generation method names (None = not declared).
     *
     * @var list<string>|null $providerDeclaredGenerationMethods
     */
    #[Optional(
        'provider_declared_generation_methods',
        list: 'string',
        nullable: true
    )]
    public ?array $providerDeclaredGenerationMethods;

    /**
     * Raw provider-specific metadata.
     *
     * @var array<string,mixed>|null $providerInfo
     */
    #[Optional('provider_info', map: 'mixed', nullable: true)]
    public ?array $providerInfo;

    /**
     * Model version identifier.
     */
    #[Optional(nullable: true)]
    public ?string $version;

    /**
     * `new Model()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Model::with(id: ..., createdAt: ..., provider: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Model)->withID(...)->withCreatedAt(...)->withProvider(...)
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
     * @param Provider|value-of<Provider> $provider
     * @param Capabilities|CapabilitiesShape|null $capabilities
     * @param Defaults|DefaultsShape|null $defaults
     * @param list<string>|null $providerDeclaredGenerationMethods
     * @param array<string,mixed>|null $providerInfo
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        Provider|string $provider,
        Capabilities|array|null $capabilities = null,
        Defaults|array|null $defaults = null,
        ?string $description = null,
        ?string $displayName = null,
        ?array $providerDeclaredGenerationMethods = null,
        ?array $providerInfo = null,
        ?string $version = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['provider'] = $provider;

        null !== $capabilities && $self['capabilities'] = $capabilities;
        null !== $defaults && $self['defaults'] = $defaults;
        null !== $description && $self['description'] = $description;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $providerDeclaredGenerationMethods && $self['providerDeclaredGenerationMethods'] = $providerDeclaredGenerationMethods;
        null !== $providerInfo && $self['providerInfo'] = $providerInfo;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * Unique model identifier with provider prefix (e.g., 'openai/gpt-4').
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the model was released (RFC 3339).
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Provider that hosts this model.
     *
     * @param Provider|value-of<Provider> $provider
     */
    public function withProvider(Provider|string $provider): self
    {
        $self = clone $this;
        $self['provider'] = $provider;

        return $self;
    }

    /**
     * Normalized model capabilities across all providers.
     *
     * @param Capabilities|CapabilitiesShape|null $capabilities
     */
    public function withCapabilities(
        Capabilities|array|null $capabilities
    ): self {
        $self = clone $this;
        $self['capabilities'] = $capabilities;

        return $self;
    }

    /**
     * Provider-declared default parameters for model generation.
     *
     * @param Defaults|DefaultsShape|null $defaults
     */
    public function withDefaults(Defaults|array|null $defaults): self
    {
        $self = clone $this;
        $self['defaults'] = $defaults;

        return $self;
    }

    /**
     * Model description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Human-readable model name.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Provider-specific generation method names (None = not declared).
     *
     * @param list<string>|null $providerDeclaredGenerationMethods
     */
    public function withProviderDeclaredGenerationMethods(
        ?array $providerDeclaredGenerationMethods
    ): self {
        $self = clone $this;
        $self['providerDeclaredGenerationMethods'] = $providerDeclaredGenerationMethods;

        return $self;
    }

    /**
     * Raw provider-specific metadata.
     *
     * @param array<string,mixed>|null $providerInfo
     */
    public function withProviderInfo(?array $providerInfo): self
    {
        $self = clone $this;
        $self['providerInfo'] = $providerInfo;

        return $self;
    }

    /**
     * Model version identifier.
     */
    public function withVersion(?string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
