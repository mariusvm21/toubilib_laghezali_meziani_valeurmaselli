<?php
declare(strict_types=1);

namespace toubilib\domain\entities;

class Patient
{
    public function __construct(
        private string $id,
        private string $nom,
        private string $prenom
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
}