<?php
declare(strict_types=1);

namespace toubilib\application\usecases;

use toubilib\application\dto\RendezVousDTO;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    public function __construct(
        private RendezVousRepositoryInterface $repository,
    ) {}

    public function annuler(string $id): RendezVousDTO
    {
        $rdv = $this->repository->getRendezVousById($id);
        $rdv->annuler();
        $this->repository->save($rdv);

        return new RendezVousDTO(
            $rdv->getId(),
            $rdv->getPraticienId(),
            $rdv->getPatientId(),
            $rdv->getDateHeureDebut()->format('Y-m-d H:i:s'),
            $rdv->getMotifVisite(),
            $rdv->getDuree(),
            $rdv->getStatut(),
        );
    }
}