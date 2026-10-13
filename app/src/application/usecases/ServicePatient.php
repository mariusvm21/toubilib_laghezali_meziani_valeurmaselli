<?php
declare(strict_types=1);

namespace toubilib\application\usecases;


use toubilib\application\dto\PatientDTO;
use toubilib\application\dto\PatientDetailDTO;
use toubilib\application\ports\api\ServicePatientInterface;
use toubilib\application\ports\spi\PatientRepositoryInterface;


class ServicePatient implements ServicePatientInterface
{

    public function __construct(
        private PatientRepositoryInterface $repository
    ) {}

    public function listerPatients(): array
    {
        $patients = $this->repository->getPatient();
        $dtos = [];

        foreach ($patients as $patient) {
            $dtos[] = new PatientDTO(
                $patient->getId(),
                $patient->getNom(),
                $patient->getPrenom(),
                (string)$patient->getSpecialiteId(),
                $patient->getVille()
            );
        }

        return $dtos;
    }

    public function getPatientDetail(string $id): PatientDetailDTO
    {
        $patient = $this->repository->getPatientById($id);

        return new PatientDetailDTO(
            $patient->getId(),
            $patient->getNom(),
            $patient->getPrenom(),
            $patient->getSpecialite()?->getLibelle() ?? '',
            $patient->getEmail(),
            $patient->getTelephone(),
            $patient->getVille(),
        );
    }
}




