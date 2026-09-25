<?php
declare(strict_types=1);

namespace toubilib\application\dto;

class RendezVousDTO
{
    public function __construct(
        public string $id,
        public string $praticienId,
        public string $patientId,
        public string $dateHeureDebut,
        public string $motifVisite,
        public int $duree,
        public int $statut,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'=> $this->id,
            'praticien_id'=> $this->praticienId,
            'patient_id'=> $this->patientId,
            'date_heure_debut'=> $this->dateHeureDebut,
            'motif_visite'=> $this->motifVisite,
            'duree'=> $this->duree,
            'statut'=> $this->statut
        ];
    }
}