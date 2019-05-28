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
    <title>Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.css'>
</head>
<body>
<h1>
    404 Not Found
</h1>
<hr>
<h3>How to create a new page <sup style="opacity: .7"><em>Bonus!</em></sup></h3>
<ol>
    <li>create an action class <code>NewProject\Action\YourAction</code></li>
    <li>register it to router in <code>NewProject\RouteDefinition</code></li>
</ol>
<fieldset>
    <legend>Request Information</legend>
    <dl>
        <dt>Method</dt><dd>METHOD</dd>
        <dt>Host</dt><dd>HOST</dd>
        <dt>Path</dt><dd>PATH</dd>
        <dt>User-Agent</dt><dd>UA</dd>
    </dl>
</fieldset>
</body>
</html>
HTML;

    protected function main(): ResponseInterface
    {
        $uri = $this->request->getUri();
        $path = $uri->getPath();
        $host = $this->request->getHeaderLine('Host');
        $method = $this->request->getMethod();

        $ua = $this->request->getHeaderLine('User-Agent');

        // a dirty string templating with `strtr`, only for demo
        $values = array_change_key_case(get_defined_vars(), CASE_UPPER);
        $html = strtr(self::SOURCE, $values);

        return new HtmlResponse($html, 404);
    }
}
