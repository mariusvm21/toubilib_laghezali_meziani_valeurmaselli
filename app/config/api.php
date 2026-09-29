<?php
declare(strict_types=1);


use Psr\Container\ContainerInterface;
use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\adapters\actions\ListerPraticiensAction;
use toubilib\application\ports\api\ServicePraticienInterface;


return [
    AnnulerRendezVousAction::class => function (ContainerInterface $c) {
        return new AnnulerRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },
    ListerPraticiensAction::class => function (ContainerInterface $c) {
        return new ListerPraticiensAction($c->get(ServicePraticienInterface::class));
    },
];