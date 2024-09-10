<?php
declare(strict_types=1);

namespace WebWizardry\Config\Collector;

trait CollectTaskTrait
{
    public function getPackageName(): string
    {
        return $this->getRequiredParam('package-name');
    }
}