<?php
declare(strict_types=1);

namespace toubilib\application\ports\api;

use toubilib\application\dto\CreeRDVDTO;
use toubilib\application\dto\RendezVousDTO;
use toubilib\application\dto\RendezVousDetailDTO;

interface ServiceRendezVousInterface
{
    public function annuler(string $id): RendezVousDTO;
    public function creerRDV(CreeRDVDTO $dto): CreeRDVDTO;
    public function getDetailsRendezVous(string $id): RendezVousDetailDTO;
    public function getRdvsByPraticien(string $praticienId): array;
}