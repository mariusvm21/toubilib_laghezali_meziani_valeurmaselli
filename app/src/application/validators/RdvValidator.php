<?php
declare(strict_types=1);

namespace toubilib\application\validators;

use toubilib\application\dto\RendezVousDTO;
use toubilib\application\exceptions\ValidationException;
use toubilib\application\ports\spi\PatientRepositoryInterface;
use toubilib\application\ports\spi\PraticienRepositoryInterface;

class RdvValidator
{
    public function __construct(
        private PraticienRepositoryInterface $praticienRepository,
        private PatientRepositoryInterface $patientRepository,
    ) {}

    public function validate(RendezVousDTO $dto): void
    {
        $errors = [];

        if (!$this->praticienRepository->existe($dto->praticienId)) {
            $errors['praticienId'] = "Le praticien n'existe pas.";
        }
        if (!$this->patientRepository->existe($dto->patientId)) {
            $errors['patientId'] = "Le patient n'existe pas.";
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
