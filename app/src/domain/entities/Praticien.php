<?php

namespace toubilib\domain\entities;

class Praticien
{

    public const RDV_CI =  30;
    public const RDV_C0 =  20;
    public const RDV_CS =  15;

    public const HORRAIRES_PREMIER_RDV = [8, 0];
    public const HORRAIRES_DERNIER_RDV = [19, 0];
    public const JOUR_TRAVAIL = [1, 2, 3, 4, 5];

    public function __construct(
        private string $id,
        private string $nom,
        private string $prenom,
        private string $ville,
        private string $email,
        private string $telephone,
        private int $specialite_id,
        private ?string $structure_id,
        private string $titre = 'Dr.',
        private ?Specialite $specialite = null,
        private array $motifs = [self::RDV_CI, self::RDV_C0, self::RDV_CS],
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getSpecialiteId(): int
    {
        return $this->specialite_id;
    }

    public function getStructureId(): ?string
    {
        return $this->structure_id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function getMotifs(): array
    {
        return $this->motifs;
    }



    public function checkMotif(string $ParamMotif): bool
    {
        foreach ($this->motifs as $motif) {
            if ($motif === $ParamMotif) {
                return true;
            }
        }
        return false;
    }

    public function jourHorrairePossible(\DateTimeImmutable $date): bool {
        $jour_rdv = (int) $date->format('N');
        $premier_rdv = $date->setTime(...Praticien::HORRAIRES_PREMIER_RDV);
        $dernier_rdv = $date->setTime(...Praticien::HORRAIRES_DERNIER_RDV);

        if (
            $date < $premier_rdv ||
            $date > $dernier_rdv ||
            !in_array($jour_rdv, Praticien::JOUR_TRAVAIL, true)
        ) {
            return false;
        }

        return true;
    }


    public function getDureePourMotif(string $motif): int
    {
        if (!$this->checkMotif($motif)) {
            throw new \InvalidArgumentException("motif existe pas");
        }
        return match ($motif) {
            'RDV_CI' => self::RDV_CI,
            'RDV_C0' => self::RDV_C0,
            'RDV_CS' => self::RDV_CS,
            default => 20,
        };
    }

}
