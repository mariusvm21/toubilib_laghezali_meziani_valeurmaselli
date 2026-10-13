<?php
declare(strict_types=1);

namespace toubilib\application\dto;

class RendezVousDetailDTO
{
    public function __construct(
        public string $id,        
        public string $praticienId,
        public string $patientId,
        public string $dateCreation,
        public string $dateDebut,
        public string $motifVisite,
        public int $duree,
        public int $statut,
        public string $praticienNom,
        public string $patientNom,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'=> $this->id,
            'praticien_nom'=> $this->praticienNom,
            'praticien_id'=> $this->praticienId,
            'patient_nom'=> $this->patientNom,
            'patient_id'=> $this->patientId,
            'date_heure_debut'=> $this->dateDebut,
            'date_creation'=> $this->dateCreation,
            'motif_visite'=> $this->motifVisite,
            'duree'=> $this->duree,
            'statut'=> $this->statut
        ];
    }
}