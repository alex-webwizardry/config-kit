<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder;

use WebWizardry\Config\BaseConfigBuilder;
use WebWizardry\Config\ApplicationConfigBuilderInterface;

final class ConfigBuilder extends BaseConfigBuilder
{
    private readonly BuildOptions $options;

    public function __construct(
        string $rootPath,
        private readonly ?ApplicationConfigBuilderInterface $appConfigBuilder = null
    ) {
        parent::__construct($rootPath);
        $this->options = new BuildOptions($rootPath);
    }

    public function run(): mixed
    {
        $container = null;

        return $this->appConfigBuilder ? $this->appConfigBuilder->run($container) : [];
    }
}