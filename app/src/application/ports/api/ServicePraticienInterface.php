<?php
declare(strict_types=1);

namespace toubilib\application\ports\api;


use toubilib\application\dto\PraticienDTO;
use toubilib\application\dto\PraticienDetailDTO;

interface ServicePraticienInterface
{
    public function listerPraticiens(): array;

    public function getPraticienDetail(string $id): PraticienDetailDTO;
}
