<?php

declare(strict_types=1);

namespace Project\Action;

use Project\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HomeAction extends BaseAction
{
    const SOURCE = <<<'HTML'
<html lang="en"><body>
<h1>Hello LitPHP!</h1>
</body></html>
HTML;

    protected function main(): ResponseInterface
    {
        return new HtmlResponse(self::SOURCE);
    }
}
