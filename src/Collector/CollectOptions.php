<?php
declare(strict_types=1);

namespace WebWizardry\Config\Collector;

use WebWizardry\Config\Base\BaseOptions;

final class CollectOptions extends BaseOptions
{
    public function __construct(string $rootPath)
    {
        parent::__construct(
            rootPath: $rootPath,
            composerConfigExtraKey: 'config-merge-plan',
            defaultConfigFile:      '{root}/config/config.merge-plan.php'
        );
    }
}