<?php

use Lit\Air\Configurator as C;

$configuration = [];

$configuration += [
    \Lit\Core\Interfaces\RouterStubResolverInterface::class => C::instance(\Lit\Bolt\Router\BoltStubResolver::class, [
        'notFound' => \Project\Action\NotFoundAction::class
    ])
];
$configuration += \Lit\Router\FastRoute\FastRouteConfiguration::default(C::produce(\Project\RouteDefinition::class));

return $configuration;
