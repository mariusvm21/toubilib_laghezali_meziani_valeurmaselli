<?php

namespace toubilib\domain\entities;


use toubilib\domain\exceptions\StatutRendezVousException;

class RendezVous
{
    public const PLANIFIE = 0;
    public const ANNULE   = 1;
    public const HONORE   = 2;
    public const IGNORE   = 3;

    public function __construct(
    private string $id,
        private string $praticienId,
        private string $patientId,
        private string $motifVisite,
        private \DateTimeImmutable $dateHeureDebut,
        private int $duree,
        private int $statut = self::PLANIFIE,
    ){

    } 
    

    public function annuler(): void{
        if ($this->statut !== self::PLANIFIE) {
            throw new StatutRendezVousException(
                "le rendez-vous n'est pas planifie"
            );
        }
        if ($this->dateHeureDebut < new \DateTimeImmutable()) {
            throw new StatutRendezVousException(
                "le rendez-vous est passe"
            );
        }
        $this->statut = self::ANNULE;
    }

    public function getId(): string { return $this->id; }
    public function getPraticienId(): string { return $this->praticienId; }
    public function getPatientId(): string { return $this->patientId; }
    public function getDateHeureDebut(): \DateTimeImmutable { return $this->dateHeureDebut; }
    public function getMotifVisite(): string { return $this->motifVisite; }
    public function getDuree(): int { return $this->duree; }
    public function getStatut(): int { return $this->statut; }
}