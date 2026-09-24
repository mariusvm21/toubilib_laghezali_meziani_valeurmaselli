<?php
declare(strict_types=1);

namespace toubilib\application\ports\spi;

interface PraticienRepositoryInterface
{
    public function existe(string $id): bool;
}
