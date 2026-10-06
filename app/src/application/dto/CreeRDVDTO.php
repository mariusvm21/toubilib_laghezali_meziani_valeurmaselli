<?php
declare(strict_types=1);
namespace toubilib\application\dto;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use toubilib\application\exceptions\ValidationException;

class CreeRDVDTO{

public function __construct(
    public string $praticienId,
    public string $patientId,
    public string $motifVisite,
    public string $dateHeureDebut,
    ) {}

    public static function fromArray(array $data): self
    {
        $requiredKeys = ['praticien_id', 'patient_id', 'motif_visite', 'date_heure_debut'];
        $errors = [];

        foreach ($requiredKeys as $key) {
            if (!isset($data[$key]) || trim((string)$data[$key]) === '') {
                $errors[] = "Le champ " . $key . " est obligatoire et ne peut pas etre vide.";
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        $praticienId = filter_var($data['praticien_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $patientId = filter_var($data['patient_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $motifVisite = filter_var($data['motif_visite'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateHeureDebut = filter_var($data['date_heure_debut'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        return new self($praticienId, $patientId, $motifVisite, $dateHeureDebut);
    }

    public function toArray(): array
    {
        return [
            'praticien_id'=> $this->praticienId,
            'patient_id'=> $this->patientId,
            'motif_visite'=> $this->motifVisite,
            'date_heure_debut'=> $this->dateHeureDebut
        ];
    }

}