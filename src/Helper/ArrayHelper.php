<?php
declare(strict_types=1);

namespace WebWizardry\Config\Helper;

final class ArrayHelper
{
    public static function pop(array &$array, string $key, $defaultValue = null): mixed
    {
        $result = $array[$key] ?? $defaultValue;
        unset($array[$key]);
        return $result;
    }
}