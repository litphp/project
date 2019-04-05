<?php

declare(strict_types=1);

namespace Project;

use League\CLImate\CLImate;

class Bootstrap
{
    public static function postCreateProject()
    {
        $climate = new CLImate();
        $ns = '';
        while (!self::isValidClassName($ns)) {
            $ns = $climate->input("Input your project namespace")->prompt();
        }

        /** @var \SplFileInfo[] $iterator */
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__));
        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile() || !$fileInfo->isReadable()) {
                continue;
            }
            if ($fileInfo->getExtension() !== 'php') {
                continue;
            }

            $pathname = $fileInfo->getPathname();
            self::replaceNamespace($pathname, $ns);
        }
        self::replaceNamespace(__DIR__.'/../configuration.php', $ns);
        copy(__DIR__.'/../configuration.php', __DIR__.'/../configuration.dist.php');
        file_put_contents(__DIR__.'/../.gitignore', "/configuration.php\n", FILE_APPEND);
        unlink(__FILE__);
    }

    protected static function isValidClassName(string $name): bool
    {
        if (strpos($name, '\\\\') !== false) {
            return false;
        }

        return !!preg_match('#^\\\\?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\\\\]*$#', $name);
    }

    /**
     * @param string $pathname
     * @param string $name
     */
    public static function replaceNamespace(string $pathname, string $name)
    {
        $content = file_get_contents($pathname);
        $content = strtr($content, ['Project' => trim($name, "\\ ")]);
        file_put_contents($pathname, $content);
    }
}
