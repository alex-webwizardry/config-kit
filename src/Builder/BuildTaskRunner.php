<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder;

use Exception;
use WebWizardry\Config\Base\BaseTaskRunner;
use WebWizardry\Config\Builder\Tasks\BuildContainer;
use WebWizardry\Config\Builder\Tasks\CopyFiles;
use WebWizardry\Config\Builder\Tasks\MergeFromFiles;
use WebWizardry\Config\Helper\ArrayHelper;

/**
 * Сценарий построения конфигурации выполняется для приложения целиком.
 *
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
final class BuildTaskRunner extends BaseTaskRunner
{
    public function __construct(BuildOptions $options, array $customTasks = [])
    {
        parent::__construct($options, array_merge([
            'copy-files' => CopyFiles::class,
            'merge' => MergeFromFiles::class,
            'build-dependencies' => BuildContainer::class,
        ], $customTasks));
    }

    /**
     * @throws Exception
     */
    public function run(array $taskConfig, array $pathParams = [], array $promoteVariables = []): mixed
    {
        if ($taskName = ArrayHelper::pop($taskConfig, 'task')) {
            $pathParams['{root}'] ??= $this->getOptions()->getRootPath();
            return $this->createTask($taskName, $taskConfig, $pathParams, $promoteVariables)->run();
        } else {
            throw new Exception("Invalid task config");
        }
    }
}