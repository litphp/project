<?php

declare(strict_types=1);

namespace NewProject;

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

        $climate->darkGray('Replacing namespace to '. $ns);
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

        $climate->darkGray('Initializing configuration...');
        $climate->white('We ignored `configuration.php`, and copied it to `configuration.dist.php`, which should be the configuration you distribute. feel free to adjust this yourself');
        copy(__DIR__.'/../configuration.php', __DIR__.'/../configuration.dist.php');
        file_put_contents(__DIR__.'/../.gitignore', "/configuration.php\n", FILE_APPEND);
        unlink(__FILE__);
        $climate->green("We've done. Run next command in your shell & browse http://127.0.0.1:3080/ to check installation. Good luck!");
        $climate->white("php -S 127.0.0.1:3080 public/index.php");
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
        $content = strtr($content, ['NewProject' => trim($name, "\\ ")]);
        file_put_contents($pathname, $content);
    }
}
