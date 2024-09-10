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

    public static function merge($a, $b): array
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            foreach (array_shift($args) as $k => $v)
            {
                if (is_int($k)) {
                    if (array_key_exists($k, $res)) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }
        return $res;
    }
}