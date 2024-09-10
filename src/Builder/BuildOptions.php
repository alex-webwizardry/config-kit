<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder;

use WebWizardry\Config\Base\BaseOptions;

final class BuildOptions extends BaseOptions
{
    public function __construct(string $rootPath)
    {
        parent::__construct(
            rootPath: $rootPath,
            composerConfigExtraKey: 'config-build-plan',
            defaultConfigFile:      '{root}/config/config.build-plan.php'
        );
    }
}