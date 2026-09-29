<?php
declare(strict_types=1);

namespace toubilib\application\dto;

class PraticienDTO
{
    public function __construct(
        public string $id,
        public string $nom,
        public string $prenom,
        public string $specialite_id,
        public string $ville
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'specialite_id' => $this->specialite_id,
            'ville' => $this->ville
        ];
    }
}