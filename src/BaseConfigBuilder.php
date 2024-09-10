<?php
declare(strict_types=1);

namespace WebWizardry\Config;

use WebWizardry\Config\Composer\ComposerFileHelper;

abstract class BaseConfigBuilder
{
    private readonly string $rootPath;
    private readonly ComposerFileHelper $composerFile;

    public function __construct(
        string $rootPath
    ){
        $this->rootPath = realpath($rootPath);
        $this->composerFile = new ComposerFileHelper($this->rootPath);
    }
}