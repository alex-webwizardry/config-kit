<?php
declare(strict_types=1);

namespace WebWizardry\Config\Builder\Tasks;

use WebWizardry\Config\Base\BaseTask;
use Exception;

final class CopyFiles extends BaseTask
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $map = $this->getRequiredParam('path');
        foreach ($map as $source => $target) {
            if (realpath($sourcePath = $this->restorePath($source))) {
                $targetPath = $this->restorePath($target);
                if (!is_dir($targetPath)) {
                    if ($mode = $this->getOptionalParam('create-target-mode', 0)) {
                        mkdir($targetPath, $mode, true);
                    }
                }
                if (!is_dir($targetPath)) {
                    throw new Exception("Target directory $targetPath does not exist");
                }

                $sourcePattern = $sourcePath . $this->getOptionalParam('source-files-mask', '');
                foreach (glob($sourcePattern) as $file) {
                    $targetFile = $targetPath . DIRECTORY_SEPARATOR . basename($file);
                    $skip = $this->getOptionalParam('skip-existing-files', true);
                    if ($skip && file_exists($targetFile)) {
                        continue;
                    }
                    copy($file, $targetFile);
                }
            }

        }
    }
}