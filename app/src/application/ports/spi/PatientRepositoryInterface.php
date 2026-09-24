<?php
declare(strict_types=1);

namespace toubilib\application\ports\spi;

interface PatientRepositoryInterface
{
    public function existe(string $id): bool;
}
