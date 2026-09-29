<?php

use Psr\Container\ContainerInterface;
use toubilib\adapters\actions\GetRendezVousAction;
use toubilib\application\ports\api\ServiceRendezVousInterface;

return [
    GetRendezVousAction::class => function (ContainerInterface $c) {
        return new GetRendezVousAction($c->get(ServiceRendezVousInterface::class));
    }
];