<?php
declare(strict_types=1);

namespace WebWizardry\Config\Collector;

use Composer\Composer;
use WebWizardry\Config\BaseConfigBuilder;
use WebWizardry\Config\Composer\ComposerFileException;

final class ConfigCollector extends BaseConfigBuilder
{
    private readonly Composer $composer;
    private readonly CollectTaskRunner $runner;

    private readonly CollectOptions $options;

    /**
     * @throws ComposerFileException
     */
    public function __construct(string $rootPath, Composer $composer)
    {
        parent::__construct($rootPath);
        $this->composer = $composer;
        $this->options = new CollectOptions($rootPath);
        $this->runner = new CollectTaskRunner($this->options);
    }

    public function run(): void
    {
        $packages = $this->composer->getRepositoryManager()->getLocalRepository()->getPackages();
        foreach ($packages as $package) {
            $packageName = $package->getPrettyName();
            $packagePath = realpath($this->composer->getInstallationManager()->getInstallPath($package));

            $packagePathMap = [
                '{package-config}' => $packagePath . DIRECTORY_SEPARATOR . 'config',
                '{package-migrations}' => $packagePath . DIRECTORY_SEPARATOR . 'migrations',
            ];

            $this->runner->run($packageName, $packagePathMap);
        }
    }
}