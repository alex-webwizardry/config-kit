<?php
declare(strict_types=1);

namespace WebWizardry\Config\Collector;

use Exception;
use WebWizardry\Config\Base\BaseTaskRunner;
use WebWizardry\Config\Builder\Tasks\CopyFiles;
use WebWizardry\Config\Collector\Tasks\CopyDependencies;
use WebWizardry\Config\Helper\ArrayHelper;

/**
 * Сценарий сборки конфигураций выполняется для каждого пакета.
 *
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
final class CollectTaskRunner extends BaseTaskRunner
{
    public function __construct(CollectOptions $options)
    {
        parent::__construct($options, [
            'copy-dependencies' => CopyDependencies::class,
            'copy-files' => CopyFiles::class,
        ]);
    }

    /**
     * @throws Exception
     */
    public function run(string $packageName, array $packagePathMap = [], array $promoteVariables = []): void
    {
        $process = $this->getOptions()->getConfig();
        foreach($process as $taskConfig) {
            if ($taskName = ArrayHelper::pop($taskConfig, 'task')) {
                $packagePathMap['{root}'] ??= $this->getOptions()->getRootPath();
                $taskConfig['package-name'] = $packageName;
                $this->createTask($taskName, $taskConfig, $packagePathMap, $promoteVariables)->run();
            } else {
                throw new Exception("Invalid task config");
            }
        }
    }
}