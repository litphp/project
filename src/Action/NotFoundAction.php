<?php

declare(strict_types=1);

namespace NewProject\Action;

use NewProject\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

class NotFoundAction extends BaseAction
{
    const SOURCE = <<<'HTML'
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
</head>
<body>
<h1>404 Not Found</h1>
<hr>
<h3>How to create a new page <sup style="opacity: .7"><em>Bonus!</em></sup></h3>
<ol>
    <li>create an action class <code>NewProject\Action\YourAction</code></li>
    <li>register it to router in <code>NewProject\RouteDefinition</code></li>
</ol>
</body>
</html>
HTML;

    protected function main(): ResponseInterface
    {
        return new HtmlResponse(self::SOURCE, 404);
    }
}
