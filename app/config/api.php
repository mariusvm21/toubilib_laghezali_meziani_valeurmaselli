<?php
declare(strict_types=1);


use Psr\Container\ContainerInterface;
use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\adapters\actions\GetRendezVousAction;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\adapters\actions\ListerPraticiensAction;
use toubilib\adapters\actions\GetPraticienAction;
use toubilib\application\ports\api\ServicePraticienInterface;
use toubilib\adapters\actions\GetRendezVousAction;


return [
    AnnulerRendezVousAction::class => function (ContainerInterface $c) {
        return new AnnulerRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },

    GetRendezVousAction::class => function (ContainerInterface $c) {
        return new GetRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },

    ListerPraticiensAction::class => function (ContainerInterface $c) {
        return new ListerPraticiensAction($c->get(ServicePraticienInterface::class));
    },

    GetPraticienAction::class => function (ContainerInterface $c) {
        return new GetPraticienAction($c->get(ServicePraticienInterface::class));
    },
        GetRendezVousAction::class => function (ContainerInterface $c) {
        return new GetRendezVousAction($c->get(ServiceRendezVousInterface::class));
    }
];