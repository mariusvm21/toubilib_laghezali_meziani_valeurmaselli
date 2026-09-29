<?php
declare(strict_types=1);

namespace toubilib\application\dto;

class PraticienDetailDTO
{
    public function __construct(
        public string $id,
        public string $titre,
        public string $nom,
        public string $prenom,
        public string $specialite,
        public string $email,
        public string $telephone,
        public string $ville,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id'=> $this->id,
            'titre'=> $this->titre,
            'nom'=> $this->nom,
            'prenom'=> $this->prenom,
            'specialite'=> $this->specialite,
            'contacts'=> [
                'email'=> $this->email,
                'telephone'=> $this->telephone,
            ],
            'adresse'=> [
                'ville'=> $this->ville,
            ],
        ];
    }
}
