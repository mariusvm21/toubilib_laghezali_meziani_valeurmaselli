<?php
declare(strict_types=1);


use Psr\Container\ContainerInterface;
use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\adapters\actions\GetPraticienAction;
use toubilib\application\ports\api\ServicePraticienInterface;


return [
    AnnulerRendezVousAction::class => function (ContainerInterface $c) {
        return new AnnulerRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },

    GetPraticienAction::class => function (ContainerInterface $c) {
        return new GetPraticienAction($c->get(ServicePraticienInterface::class));
    },
];