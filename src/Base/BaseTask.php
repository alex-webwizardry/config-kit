<?php
declare(strict_types=1);

namespace WebWizardry\Config\Base;

use InvalidArgumentException;

abstract class BaseTask
{
    private readonly array $pathParams;
    private readonly array $promoteVariables;

    final public function __construct(
        private readonly array $config = [],
        array $pathParams = [],
        array $promoteVariables = []
    ){
        $pathParams['{sapi}'] = 'cli' === php_sapi_name() ? 'console' : 'http';
        $this->pathParams = $pathParams;
    }

    protected function getRequiredParam(string $name): mixed
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
        throw new InvalidArgumentException("Required config param '{$name}' not found");
    }

    protected function getOptionalParam(string $name, $default = null): mixed
    {
        return $this->config[$name] ?? $default;
    }

    protected function restorePath(string $path): string
    {
        print_r($this->pathParams);
        return strtr($path, $this->pathParams);
    }

    abstract public function run();
}