<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use toubilib\adapters\RendezVousRepository;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\application\usecases\ServiceRendezVous;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\adapters\PraticienRepository;
use toubilib\application\ports\spi\PraticienRepositoryInterface;
use toubilib\application\ports\api\ServicePraticienInterface;
use toubilib\application\usecases\ServicePraticien;
use toubilib\adapters\PatientRepository;
use toubilib\application\ports\spi\PatientRepositoryInterface;
use toubilib\application\validators\RdvValidator;

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
        return new ServiceRendezVous(
            $c->get(RendezVousRepositoryInterface::class),
            $c->get(RdvValidator::class) // On injecte le validateur ici !
        );
    },
    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PraticienRepository($c->get(PDO::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },
    PatientRepositoryInterface::class => function (ContainerInterface $c) {
        return new PatientRepository($c->get(PDO::class));
    },
    RdvValidator::class => function (ContainerInterface $c) {
        return new RdvValidator(
            $c->get(PraticienRepositoryInterface::class),
            $c->get(PatientRepositoryInterface::class)
        );
    },
];
