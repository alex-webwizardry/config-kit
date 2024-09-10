<?php
declare(strict_types=1);

namespace WebWizardry\Config\Helper;

use Exception;

final class RequireHelper
{
    /**
     * @throws Exception
     */
    public static function requireArrayFromFile(string $filePath, array $promoteVariables = []): array
    {
        self::assertFileExistsAndReadable($filePath);
        foreach ($promoteVariables as $k => $v) {
            $$k = $v;
        }
        $data = require $filePath;
        self::assertIsArray($data, $filePath);
        return $data;
    }

    /**
     * @throws Exception
     */
    public static function require(string $path, callable $callback = null, array $promoteVariables = []): void
    {
        if (false === realpath($path)) return;
        is_dir($path)
            ? self::requireFromDirectory($path, $callback, $promoteVariables)
            : self::requireFromFile($path, $callback, $promoteVariables);
    }

    /**
     * @throws Exception
     */
    private static function assertFileExistsAndReadable(string $filePath): void
    {
        if (!file_exists($filePath)) throw new Exception("File does not exist: " . $filePath);
        if (!is_readable($filePath)) throw new Exception("File is not readable: " . $filePath);
    }

    /**
     * @throws Exception
     */
    private static function assertIsArray($array, string $filePath): void
    {
        if (!is_array($array)) {
            throw new Exception("File is not an array: " . $filePath);
        }
    }

    /**
     * @throws Exception
     */
    private static function requireFromDirectory(string $path, callable $callback, array $promoteVariables = []): void
    {
        foreach (glob($path . '/*.php') as $file) {
            self::requireFromFile($file, $callback, $promoteVariables);
        }
    }

    /**
     * @throws Exception
     */
    private static function requireFromFile(string $path, callable $callback, array $promoteVariables = []): void
    {
        call_user_func_array($callback, [self::requireArrayFromFile($path, $promoteVariables), $path]);
    }
}