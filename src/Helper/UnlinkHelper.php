<?php
declare(strict_types=1);

namespace WebWizardry\Config\Helper;

final class UnlinkHelper
{
    public static function unlink(string $path): void
    {
        is_dir($path)
            ? self::unlinkFromPath($path)
            : self::unlinkFile($path);
    }

    private static function unlinkFile(string $path): void
    {
        if (is_file($path)) {
            unlink($path);
        }
    }

    private static function unlinkFromPath(string $path): void
    {
        foreach (glob($path) as $file) {
            self::unlinkFile($file);
        }
    }
}