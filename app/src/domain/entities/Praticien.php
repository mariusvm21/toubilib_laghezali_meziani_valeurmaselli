<?php

namespace toubilib\domain\entities;

class Praticien
{
    public const MOTIFS_DUREES = [
        'CI' => 30,
        'C0' => 20,
        'CS' => 15,
    ];

    public function __construct(
        private int $id,
        private string $nom,
        private string $prenom,
        private string $ville,
        private string $email,
        private string $telephone,
        private int $specialite_id,
        private int $structure_id,
        private array $motifs = [self::MOTIFS_DUREES],
    ) {}

    public function getId(): int
    {
        return $this->id;
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

    public function getDureePourMotif(string $motif): int
    {
        if (!$this->checkMotif($motif)) {
            throw new \InvalidArgumentException("motif existe pas");
        }
        return $this->motifs[$motif];
    }

}
