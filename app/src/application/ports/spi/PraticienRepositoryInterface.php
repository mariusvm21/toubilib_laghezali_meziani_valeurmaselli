<?php
declare(strict_types=1);

namespace toubilib\application\ports\spi;

use toubilib\domain\entities\Praticien;

interface PraticienRepositoryInterface
{
    public function existe(string $id): bool;
    public function getPraticien(): array;
    public function getPraticienById(string $id): Praticien;
    public function getPraticienAvecRdvs(string $id): Praticien;
}
