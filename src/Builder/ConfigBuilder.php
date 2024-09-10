<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder;

use Exception;
use WebWizardry\Config\BaseConfigBuilder;
use WebWizardry\Config\ApplicationConfigBuilderInterface;
use WebWizardry\Config\Composer\ComposerFileException;

final class ConfigBuilder extends BaseConfigBuilder
{
    private readonly BuildOptions $options;
    private readonly BuildTaskRunner $runner;

    /**
     * @throws ComposerFileException
     */
    public function __construct(
        string $rootPath,
        private readonly ?ApplicationConfigBuilderInterface $appConfigBuilder = null
    ) {
        parent::__construct($rootPath);
        $this->options = new BuildOptions($rootPath);
        $this->runner = new BuildTaskRunner($this->options);
    }

    /**
     * @throws Exception
     */
    public function run(): mixed
    {
        $params = [];
        if ($config = $this->options->getSection('container-params')) {
            $params = $this->runner->run($config);
        }

        $container = null;
        if ($config = $this->options->getSection('container')) {
            $container = $this->runner->run($config, promoteVariables: ['params' => $params]);
        }

        return $this->appConfigBuilder ? $this->appConfigBuilder->run($container) : [];
    }
}