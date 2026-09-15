<?php
declare(strict_types=1);


use psr\Container\ContainerInterface;
use toubilib\adapters\actions\AnnulerRendezVousAction;
use toubilib\application\ports\api\ServiceRendezVousInterface;


return [
    AnnulerRendezVousAction::class => function (ContainerInterface $c) {
        return new AnnulerRendezVousAction($c->get(ServiceRendezVousInterface::class));
    },
];