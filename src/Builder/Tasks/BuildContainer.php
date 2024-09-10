<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder\Tasks;

use Exception;
use Psr\Container\ContainerInterface;
use WebWizardry\Config\Base\BaseTask;
use WebWizardry\Config\Helper\RequireHelper;
use WebWizardry\Di\Container;
use WebWizardry\Di\ContainerBuilder;
use WebWizardry\Di\ContainerBuilderInterface;

final class BuildContainer extends BaseTask
{

    /**
     * @throws Exception
     */
    public function run(): ContainerInterface
    {
        $bc = $this->getOptionalParam('container-builder-class', ContainerBuilder::class);
        $cc = $this->getOptionalParam('container-class', Container::class);

        $builder = new $bc($cc);
        assert($builder instanceof ContainerBuilderInterface);

        foreach ($this->getRequiredParam('path') as $path) {
            $restoredPath = $this->restorePath($path);
            RequireHelper::require($restoredPath, function(array $definitions, string $filename) use ($builder) {
                $builder->addDefinitions($definitions);
            }, $this->getPromoteVariables());
        }

        return $builder->build();
    }
}