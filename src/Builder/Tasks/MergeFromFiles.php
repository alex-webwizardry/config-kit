<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder\Tasks;

use Exception;
use WebWizardry\Config\Base\BaseTask;
use WebWizardry\Config\Helper\ArrayHelper;
use WebWizardry\Config\Helper\RequireHelper;

final class MergeFromFiles extends BaseTask
{

    /**
     * @throws Exception
     */
    public function run(): array
    {
        $result = [];

        $key = $this->getOptionalParam('filename-as-key', false);
        foreach ($this->getRequiredParam('path') as $path) {
            $restoredPath = $this->restorePath($path);
            RequireHelper::require($restoredPath, function (array $array, string $filename) use ($key, &$result) {
               if ('basename' === $key) {
                   $array = [basename($filename, '.php') => $array];
               }
               $result = ArrayHelper::merge($result, $array);
            }, $this->getPromoteVariables());
        }

        return $result;
    }
}