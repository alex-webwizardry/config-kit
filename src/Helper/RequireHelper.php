<?php
declare(strict_types=1);

namespace WebWizardry\Config\Helper;

use Exception;

final class RequireHelper
{
    /**
     * @throws Exception
     */
    public static function requireArrayFromFile(string $filePath): array
    {
        if (!file_exists($filePath)) throw new Exception("File does not exist: " . $filePath);
        if (!is_readable($filePath)) throw new Exception("File is not readable: " . $filePath);
        $data = require $filePath;
        if (!is_array($data)) {
            throw new Exception("File is not an array: " . $filePath);
        }
        return $data;
    }
}