<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use toubilib\adapters\RendezVousRepository;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\application\usecases\ServiceRendezVous;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\adapters\PraticienRepository;
use toubilib\application\ports\spi\PraticienRepositoryInterface;
use toubilib\application\usecases\ServicePraticien;
use toubilib\application\ports\api\ServicePraticienInterface;

return [
    PDO::class => function (ContainerInterface $c) {
        return new PDO(
            $c->get('db.dsn'),
            $c->get('db.username'),
            $c->get('db.password'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    },

    RendezVousRepositoryInterface::class => function (ContainerInterface $c) {
        return new RendezVousRepository($c->get(PDO::class));
    },

    ServiceRendezVousInterface::class => function (ContainerInterface $c) {
        return new ServiceRendezVous($c->get(RendezVousRepositoryInterface::class));
    },

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PraticienRepository($c->get(PDO::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },
];