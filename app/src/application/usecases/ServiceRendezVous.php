<?php
declare(strict_types=1);

namespace toubilib\application\usecases;

use toubilib\application\dto\RendezVousDTO;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\application\exceptions\RendezVousNotFoundException;
use toubilib\application\dto\CreeRDVDTO;
use toubilib\application\validators\RdvValidator;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $repository;
    private RdvValidator $validator;

    public function __construct(RendezVousRepositoryInterface $repository) {
        $this->repository = $repository;

    }

    public function annuler(string $id): RendezVousDTO
    {
        try {
            $rdv = $this->repository->getRendezVousById($id);
        } catch (RendezVousNotFoundException $e) {
            throw $e;
        }
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

    public function creerRDV(CreeRDVDTO $dto): CreeRDVDTO    {
        $this->validator->validate($dto);
        return $dto;
    }

    public function getDetailsRendezVous(string $id): RendezVousDTO {
        try {
            $rdv = $this->repository->getRendezVousById($id);
        } catch {
            (RendezVousNotFoundException $e) {
                throw $e;
            }
        }
        return new RendezVousDTO(
            $rdv->getId(),
            $rdv->getPraticienId(),
            $rdv->getPatientId(),
            $rdv->getDateHeureDebut()->format('Y-m-d H:i:s'),
            $rdv->getMotifVisite(),
            $rdv->getDuree(),
            $rdv->getStatut()
        );
    }
}