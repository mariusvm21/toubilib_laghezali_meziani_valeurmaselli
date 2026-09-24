<?php
declare(strict_types=1);
namespace toubilib\application\dto;

class CreeRDVDTO{

public function __construct(
    public string $praticienId,
    public string $patientId,
    public string $motifVisite,
    public string $dateHeureDebut,
    ) {}

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