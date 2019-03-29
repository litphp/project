<?php

namespace Project;

use FastRoute\RouteCollector;
use Lit\Router\FastRoute\FastRouteDefinition;
use Project\Action\HomeAction;

class RouteDefinition extends FastRouteDefinition
{
    public function __invoke(RouteCollector $routeCollector): void
    {
        $routeCollector->get('/', HomeAction::class);
    }
}
