<?php
declare(strict_types=1);

namespace WebWizardry\Config\Collector\Tasks;

use Exception;
use WebWizardry\Config\Base\BaseTask;
use WebWizardry\Config\Collector\CollectTaskTrait;
use WebWizardry\Config\Helper\UnlinkHelper;

class CopyDependencies extends BaseTask
{
    use CollectTaskTrait;

    private static bool $directoryClean = false;

    /**
     * @throws Exception
     */
    public function run()
    {
        $map = $this->getRequiredParam('files');

        if ($this->getOptionalParam('unlink-before-copy', false) && !self::$directoryClean) {
            foreach ($map as $file) {
                UnlinkHelper::unlink($this->restorePath($file));
                self::$directoryClean = true;
            }
        }

        foreach ($map as $source => $target) {
            if ($sourceFile = realpath($this->restorePath($source))) {
                $targetPath = $this->restorePath($target);
                if (!is_dir($targetPath)) {
                    if ($mode = $this->getOptionalParam('create-target-mode', 0)) {
                        mkdir($targetPath, $mode, true);
                    }
                }
                if (!is_dir($targetPath)) {
                    throw new Exception("Target directory $targetPath does not exist");
                }
                $targetFile = $targetPath . DIRECTORY_SEPARATOR . str_replace('/', '-', $this->getRequiredParam('package-name')) . '.php';
                copy($sourceFile, $targetFile);
            }
        }
    }
}