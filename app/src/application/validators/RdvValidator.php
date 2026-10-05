<?php
declare(strict_types=1);

namespace toubilib\application\validators;

use toubilib\application\dto\CreeRDVDTO;
use toubilib\application\exceptions\PraticienNotFoundException;
use toubilib\application\exceptions\ValidationException;
use toubilib\application\ports\spi\PatientRepositoryInterface;
use toubilib\application\ports\spi\PraticienRepositoryInterface;

class RdvValidator
{
    public function __construct(
        private PraticienRepositoryInterface $praticienRepository,
        private PatientRepositoryInterface $patientRepository,
    ) {}

    public function validate(CreeRDVDTO $dto): void
    {
        $errors = [];

        if (!$this->patientRepository->existe($dto->patientId)) {
            $errors['patientId'] = "Le patient n'existe pas.";
        }

        $date = \DateTimeImmutable::createFromFormat('!Y-m-d H:i:s', $dto->dateHeureDebut);
        if ($date === false) {
            $errors['dateHeureDebut'] = "La date doit être au format Y-m-d H:i:s.";
        } elseif ($date <= new \DateTimeImmutable()) {
            $errors['dateHeureDebut'] = "La date du rendez-vous doit être dans le futur.";
        }

        try {
            $praticien = $this->praticienRepository->getPraticienAvecRdvs($dto->praticienId);
        } catch (PraticienNotFoundException) {
            $errors['praticienId'] = "Le praticien n'existe pas.";
            throw new ValidationException($errors);
        }

        if (!$praticien->checkMotif($dto->motifVisite)) {
            $errors['motifVisite'] = "Le motif n'est pas proposé par ce praticien.";
        }

        if (!isset($errors['dateHeureDebut']) && !$praticien->jourHorrairePossible($date)) {
            $errors['dateHeureDebut'] = "Le praticien ne consulte pas à ce jour ou à cette heure.";
        }

        if (empty($errors)) {
            $duree = $praticien->getDureePourMotif($dto->motifVisite);
            if (!$praticien->rdvdemandRdvCompatibleAgenda($date, $duree)) {
                $errors['dateHeureDebut'] = "Le praticien n'est pas disponible sur ce créneau.";
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
