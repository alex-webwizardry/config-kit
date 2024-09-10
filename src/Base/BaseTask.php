<?php
declare(strict_types=1);

namespace WebWizardry\Config\Base;

use http\Encoding\Stream\Deflate;
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
        $this->promoteVariables = $promoteVariables;
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
        return strtr($path, $this->pathParams);
    }

    protected function getPromoteVariables(): array
    {
        return $this->promoteVariables;
    }

    abstract public function run();
}