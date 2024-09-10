<?php
declare(strict_types=1);

namespace WebWizardry\Config\Composer;

class ComposerFileHelper
{
    private readonly array $config;

    /**
     * @throws ComposerFileException
     */
    public function __construct(string $directory)
    {
        $composerFile = $directory . '/composer.json';
        if (file_exists($composerFile) && is_readable($composerFile)) {
            $composerJson = file_get_contents($composerFile);
            $this->config = json_decode($composerJson, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new ComposerFileException(json_last_error_msg());
            }
        } else {
            throw new ComposerFileException(
                sprintf('Composer file "%s" does not exist or is not readable', $composerFile)
            );
        }
    }

    public function getExtraValue(string $name, string $default = null): mixed
    {
        return $this->config['extra'][$name] ?? $default;
    }
}