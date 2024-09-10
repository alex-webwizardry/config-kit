<?php
declare(strict_types=1);

namespace WebWizardry\Config\Base;

use InvalidArgumentException;

class BaseTaskRunner
{
    public function __construct(
        private readonly BaseOptions $options,
        private readonly array $tasks = []
    ){}

    public function getOptions(): BaseOptions
    {
        return $this->options;
    }

    protected function createTask(
        string $name,
        array $config,
        array $pathParams = [],
        array $promoteVariables = []
    ): BaseTask {
        if (!array_key_exists($name, $this->tasks)) {
            throw new InvalidArgumentException("Task '{$name}' does not exist.");
        }
        $class = $this->tasks[$name];
        return new $class($config, $pathParams, $promoteVariables);
    }
}