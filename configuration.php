<?php

use Lit\Air\Configurator as C;

$configuration = [];

$configuration += [
    C::join(\Lit\Router\FastRoute\FastRouteRouter::class, 'notFound') =>  \NewProject\Action\NotFoundAction::class
];
$configuration += \Lit\Router\FastRoute\FastRouteConfiguration::default(C::produce(\NewProject\RouteDefinition::class));

return $configuration;
