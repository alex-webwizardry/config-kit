<?php
declare(strict_types=1);

namespace WebWizardry\Config;

use Psr\Container\ContainerInterface;

interface ApplicationConfigBuilderInterface
{
    public function run(ContainerInterface $container = null): mixed;
}