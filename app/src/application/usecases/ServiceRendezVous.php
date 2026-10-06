<?php
declare(strict_types=1);

namespace toubilib\application\usecases;

use toubilib\application\dto\RendezVousDTO;
use toubilib\application\ports\api\ServiceRendezVousInterface;
use toubilib\application\ports\spi\RendezVousRepositoryInterface;
use toubilib\application\ports\spi\PatientRepositoryInterface;
use toubilib\application\ports\spi\PraticienRepositoryInterface;
use toubilib\application\exceptions\RendezVousNotFoundException;
use toubilib\application\dto\CreeRDVDTO;
use toubilib\application\validators\RdvValidator;
use toubilib\application\exceptions\ValidationException;
use toubilib\domain\entities\RendezVous;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $repository;
    private RdvValidator $validator;
    private PatientRepositoryInterface $patientRepository;
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(RendezVousRepositoryInterface $repository, RdvValidator $validator, PatientRepositoryInterface $patientRepository, PraticienRepositoryInterface $praticienRepository) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->patientRepository = $patientRepository;
        $this->praticienRepository = $praticienRepository;
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

    public function getDetailsRendezVous(string $id): RendezVousDTO {
        try {
            $rdv = $this->repository->getRendezVousById($id);
        } catch (RendezVousNotFoundException $e) {
            throw $e;
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

    public function creerRDV(CreeRDVDTO $dto): CreeRDVDTO
    {
        $patient = $this->patientRepository->getById($dto->patientId);
        
        $dateRecherche = (new \DateTimeImmutable($dto->dateHeureDebut))->format('Y-m-d');
        $praticien = $this->praticienRepository->getByIdAvecAgenda($dto->praticienId, $dateRecherche);

        $rendezVous = RendezVous::cree(
            $praticien,
            $patient->getId(),
            $dto->motifVisite,
            new \DateTimeImmutable($dto->dateHeureDebut)
        );

        $this->repository->save($rendezVous);

        return $dto;
    }
}