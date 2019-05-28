<?php

declare(strict_types=1);

namespace NewProject\Action;

use NewProject\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HomeAction extends BaseAction
{
    const SOURCE = <<<'HTML'
<html lang="en">
<head>
<title>Welcome</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
</head>
<body>
<h1>Hello <strong>LitPHP</strong></h1>
<hr>
There's <a href="./404">a not found page</a> with more information.
</body>
</html>
HTML;

    protected function main(): ResponseInterface
    {
        return new HtmlResponse(self::SOURCE);
    }
}
