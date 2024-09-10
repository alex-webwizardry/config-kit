<?php
declare(strict_types=1);

namespace WebWizardry\Config\Base;

use Exception;
use WebWizardry\Config\Composer\ComposerFileException;
use WebWizardry\Config\Composer\ComposerFileHelper;
use WebWizardry\Config\Helper\RequireHelper;

abstract class BaseOptions
{
    private readonly array $config;

    /**
     * @throws ComposerFileException
     * @throws Exception
     */
    public function __construct(
        private readonly string $rootPath,
        string $composerConfigExtraKey,
        string $defaultConfigFile
    ) {
        $helper = new ComposerFileHelper($this->rootPath);
        $fileName = strtr($helper->getExtraValue($composerConfigExtraKey, $defaultConfigFile), [
            '{root}' => realpath($this->rootPath),
        ]);
        $this->config = RequireHelper::requireArrayFromFile($fileName);
    }

    final public function getRootPath(): string
    {
        return realpath($this->rootPath);
    }

    final public function getConfig(): array
    {
        return $this->config;
    }
}