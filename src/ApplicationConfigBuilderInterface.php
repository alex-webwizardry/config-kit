<?php
declare(strict_types=1);

namespace WebWizardry\Config;

use Psr\Container\ContainerInterface;
use WebWizardry\Config\Builder\BuildOptions;
use WebWizardry\Config\Builder\BuildTaskRunner;

interface ApplicationConfigBuilderInterface
{
    public function run(
        ContainerInterface $container = null,
        BuildOptions $buildOptions = null,
        BuildTaskRunner $runner = null
    ): mixed;
}